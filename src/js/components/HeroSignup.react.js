"use strict";

var React = require("react");
var cx = require("classnames");

var API = require("../api");

var EditUserInfo = require("./EditUserInfo.react");
var Input = require("./Input.react");

var HeroSignup = React.createClass({
  getInitialState: function() {
    return {
      loading: false,
      isBasicSent: false
    };
  },

  render: function() {
    return (
      <div className="wrap">
        <form onSubmit={this.submit}>
          {this.renderBasic()}
        </form>
        {this.renderMore()}
      </div>
    );
  },

  renderInputEmail: function() {
    return <Input
      className="signup-input signup-input-email"
      disabled={this.state.isBasicSent}
      name="email"
      onChange={this.onChange}
      placeholder="E-mail"
      type="text"
      value={this.state.email}
      />;
  },

  renderInputLocation: function() {
    return <Input
      className="signup-input signup-input-location"
      disabled={this.state.isBasicSent}
      name="location"
      onChange={this.onChange}
      placeholder="Bairro (ou município, caso não seja capital)"
      suggestions={true}
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
    return <div className="basic-form">
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
      }.bind(this);

      return (
        <div className="lightbox-overlay-tablet" onClick={overlayClick}>
          <EditUserInfo />
        </div>
      );
    } else {
      return null;
    }
  },

  onChange: function(name, value) {
    var dict = {};
    dict[name] = value;
    this.setState(dict);
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
