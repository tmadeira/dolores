"use strict";

var React = require("react");

var API = require("../api");

var Authenticator = React.createClass({
  getInitialState: function() {
    return {
      auth: {},
      clientInfo: {},
      serverInfo: {},
      show: false,
      waiting: false
    };
  },

  componentWillMount: function() {
    window.DoloresAuthenticator = {
      signIn: function() {
        this.setState({
          show: true
        });
      }.bind(this),

      setAuth: function(auth) {
        this.setState({
          auth: auth,
          waiting: true
        });

        API.route("signin").post(auth).done(function(data) {
          console.log("data", data);
          this.setState({
            waiting: false
          });
        }.bind(this)).fail(function(data) {
          console.log(data);
        });
      }.bind(this),

      hasAuth: function(type) {
        return this.hasAuth() && this.state.auth.type === type;
      }.bind(this)
    };
  },

  hasAuth: function() {
    return "type" in this.state.auth;
  },

  hasServerInfo: function() {
    return "email" in this.state.serverInfo &&
      "location" in this.state.serverInfo;
  },

  signinWithFacebook: function() {
    window.fbLogin();
  },

  signinWithGoogle: function() {
    window.googleLogin();
  },

  hide: function() {
    this.setState({
      show: false
    });
  },

  overlayClick: function(e) {
    if (e.target.className === "lightbox-overlay") {
      this.hide();
    }
  },

  render: function() {
    if (this.hasAuth()) {
      if (this.hasServerInfo()) {
        /* User is logged in. */
        window.location.reload();
        return null;
      } else {
        /* We have a token from Google or Facebook.
         * TODO: request user information (email and location) */
      }
    }

    var lightboxContent = null;

    if (this.state.waiting) {
      lightboxContent = (
        <div className="lightbox-wrap">
          <p style={{textAlign: "center"}}>Carregando...</p>
        </div>
      );
    } else {
      lightboxContent = (
        <div className="lightbox-wrap">
          <p className="signin-text">
            Conecte-se para participar das discussões na plataforma:
          </p>
          <button
              className="signin-button signin-facebook"
              onClick={this.signinWithFacebook}
              >
            Entrar com Facebook
          </button>
          <button
              className="signin-button signin-google"
              onClick={this.signinWithGoogle}
              >
            Entrar com Google
          </button>
        </div>
      );
    }

    if (!this.state.show) {
      return null;
    }

    return (
      <div className="lightbox-overlay" onClick={this.overlayClick}>
        <div className="lightbox">
          <button className="lightbox-close" onClick={this.hide}>X</button>
          {lightboxContent}
        </div>
      </div>
    );
  }
});

module.exports = Authenticator;
