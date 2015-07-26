"use strict";

var React = require("react");
var cx = require("classnames");

var API = require("../api");

var EditUserInfo = require("./EditUserInfo.react");

var HeroSignup = React.createClass({
  getInitialState: function() {
    return {
      loading: false,
      isBasicSent: false,

      // Fields
      email: "",
      location: ""
    };
  },

  render: function() {
    return (
      <div className="wrap">
        <form className="hero-signup-form" onSubmit={this.submit}>
          {this.renderBasic()}
          {this.renderMore()}
        </form>
      </div>
    );
  },

  renderInputEmail: function() {
    return <input
      className="signup-input signup-input-email"
      disabled={this.state.isBasicSent}
      onChange={this.setEmail}
      placeholder="E-mail"
      type="text"
      value={this.state.email}
      />;
  },

  renderInputLocation: function() {
    return <input
      className="signup-input signup-input-location"
      disabled={this.state.isBasicSent}
      onChange={this.setLocation}
      placeholder="Bairro (ou município, caso não seja capital)"
      type="text"
      value={this.state.location}
      />;
  },

  renderButton: function() {
    var className = cx({
      "signup-button": true,
      "is-basic-sent": this.state.isBasicSent
    });
    return (
      <button
          className={className}
          disabled={this.state.loading}
          type="submit"
          >
        Participar
      </button>
    );
  },

  renderBasic: function() {
    return <div>
      {this.renderInputEmail()}
      {this.renderInputLocation()}
      {this.renderButton()}
    </div>;
  },

  renderMore: function() {
    if (this.state.isBasicSent) {
      var overlayClick = function(e) {
        if (e.target.className === "lightbox-overlay-tablet") {
          this.setState({
            isBasicSent: false
          });
          e.preventDefault();
        }
      };

      return (
        <div className="lightbox-overlay-tablet" onClick={overlayClick}>
          <EditUserInfo />
        </div>
      );
    } else {
      return null;
    }
  },

  setLocation: function(e) {
    this.setState({
      location: e.target.value
    });
  },

  setEmail: function(e) {
    this.setState({
      email: e.target.value
    });
  },

  submit: function(e) {
    this.setState({
      loading: true
    });

    API.route("test").get({"hello": "world"}).done(function(data) {
      this.setState({
        loading: false,
        isBasicSent: true
      });

      console.log(data);
    }.bind(this));

    e.preventDefault();
  }
});

module.exports = HeroSignup;
