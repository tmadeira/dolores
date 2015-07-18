"use strict";

var React = require("react");

var InputEmail = React.createClass({
  render: function() {
    // TODO
    return <input
      className="signup-input"
      placeholder="E-mail"
      type="text"
      />;
  }
});

var InputLocation = React.createClass({
  render: function() {
    // TODO
    return <input
      className="signup-input"
      placeholder="Bairro (ou município, caso não seja capital)"
      type="text"
      />;
  }
});

var HeroSignup = React.createClass({
  render: function() {
    return <div className="wrap">
      <form className="hero-signup-form">
        <InputEmail />
        <InputLocation />
        <button className="signup-button" onClick={this.join}>
          Participar
        </button>
      </form>
    </div>;
  },

  join: function(e) {
    // TODO
    e.preventDefault();
  }
});

module.exports = HeroSignup;
