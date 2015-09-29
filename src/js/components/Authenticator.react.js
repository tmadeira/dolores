"use strict";

var React = require("react");

var API = require("../api");

var Authenticator = React.createClass({
  getInitialState: function() {
    return {
      auth: {},
      data: {},
      show: false,
      signup: false,
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

        API.route("signin").post(auth).done(function(response) {
          if (response.action === "refresh") {
            location.reload();
          } else if (response.action === "signup") {
            this.setState({
              signup: true,
              data: response.data,
              waiting: false
            });
          }
        }.bind(this)).fail(function(response) {
          console.log(response);
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
    if (!this.state.show) {
      return null;
    }

    var lightboxContent = null;

    if (this.state.waiting) {
      lightboxContent = (
        <div className="lightbox-wrap">
          <p style={{textAlign: "center"}}>Carregando...</p>
        </div>
      );
    } else if (this.state.signup) {
      lightboxContent = (
        <div className="lightbox-wrap">
          <p>Nome: {this.state.data.name}</p>
          <p>E-mail: {this.state.data.email}</p>
          <p><img src={this.state.data.picture} /></p>
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
