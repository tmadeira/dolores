"use strict";

var $ = require("jquery");
var React = require("react");
var cx = require("classnames");

var API = require("../api");

var SignupForm = require("./SignupForm.react");
var ProfileForm = require("./ProfileForm.react");

var defaultMessage = "Conecte-se e dê suas ideias para a cidade:";

var defaultRefreshCallback = function() {
  location.reload();
};

var Authenticator = React.createClass({
  getInitialState: function() {
    return {
      auth: {},
      data: {},
      show: false,
      signup: false,
      profile: false,
      waiting: false
    };
  },

  componentWillMount: function() {
    window.DoloresAuthenticator = {
      signIn: function(message, refreshCallback) {
        var newState = {
          show: true
        };

        if (message != null) {
          newState.message = message;
        } else {
          newState.message = defaultMessage;
        }

        if (refreshCallback != null) {
          newState.refreshCallback = refreshCallback;
        } else {
          newState.refreshCallback = defaultRefreshCallback;
        }

        if ($("body").hasClass("logged-in")) {
          newState.refreshCallback();
        } else {
          this.setState(newState);
        }
      }.bind(this),

      editUserInfo: function() {
        window.DoloresAuthenticator.signIn(null, function() {
          this.setState({
            profile: true,
            show: true,
            waiting: true
          });
          API.route("userinfo").get().done(function(response) {
            this.setState({
              profileData: response.data,
              refreshCallback: defaultRefreshCallback,
              waiting: false
            });
          }.bind(this)).fail(function(response) {
            console.log(response);
            if ("error" in response.responseJSON) {
              alert("Erro: " + response.responseJSON.error);
            }
            this.setState({
              profile: false,
              show: false,
              waiting: false
            });
          }.bind(this));
        }.bind(this));
      }.bind(this),

      setAuth: function(auth) {
        this.setState({
          auth: auth,
          waiting: true
        });

        API.route("signin").post(auth).done(function(response) {
          if (response.action === "refresh") {
            this.refresh();
          } else if (response.action === "signup") {
            var data = response.data;
            data.auth = auth;
            this.setState({
              signup: true,
              data: data,
              waiting: false
            });
          }
        }.bind(this)).fail(function(data) {
          alert("Erro na autenticação: " + data.responseJSON.error);
          location.reload();
          this.setState({
            waiting: false
          });
        });
      }.bind(this),

      hasAuth: function(type) {
        return this.hasAuth() && this.state.auth.type === type;
      }.bind(this)
    };
  },

  refresh: function() {
    $("body").addClass("logged-in");
    // TODO: async fetch/set header
    this.setState(this.getInitialState());
    this.state.refreshCallback();
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
    this.setState(this.getInitialState());
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

    var className = {
      lightbox: true
    };
    var lightboxContent = null;

    if (this.state.waiting) {
      var spinner = "fa fa-refresh fa-spin fa-4x";
      className.small = true;
      lightboxContent = (
        <div className="lightbox-wrap">
          <p style={{textAlign: "center"}}><i className={spinner}></i></p>
          <p style={{textAlign: "center"}}>Carregando...</p>
        </div>
      );
    } else if (this.state.signup) {
      lightboxContent = (
        <div className="lightbox-wrap">
          <SignupForm
              data={this.state.data}
              refreshCallback={this.refresh}
              >
          </SignupForm>
        </div>
      );
    } else if (this.state.profile) {
      lightboxContent = (
        <div className="lightbox-wrap">
          <ProfileForm
              data={this.state.profileData}
              refreshCallback={this.refresh}
              >
          </ProfileForm>
        </div>
      );
    } else {
      className.small = true;
      lightboxContent = (
        <div className="lightbox-wrap">
          <p className="signin-text">{this.state.message}</p>
          <button
              className="signin-button signin-facebook"
              onClick={this.signinWithFacebook}
              >
            <i className="fa fa-2x fa-fw fa-facebook"></i>
            Conectar com Facebook
          </button>
          <button
              className="signin-button signin-google"
              onClick={this.signinWithGoogle}
              >
            <i className="fa fa-2x fa-fw fa-google"></i>
            Conectar com Google
          </button>
        </div>
      );
    }

    return (
      <div className="lightbox-overlay" onClick={this.overlayClick}>
        <div className={cx(className)}>
          <button className="lightbox-close" onClick={this.hide}>X</button>
          {lightboxContent}
        </div>
      </div>
    );
  }
});

module.exports = Authenticator;
