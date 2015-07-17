"use strict";

var React = require("react");

var InputEmail = React.createClass({
  render: function() {
    // TODO
    return <input placeholder="E-mail" />;
  }
});

var InputLocation = React.createClass({
  render: function() {
    // TODO
    return <input placeholder="Bairro (ou município, caso não seja capital)" />;
  }
});

var HeroSignup = React.createClass({
  render: function() {
    return <div className="wrap">
      <form>
        <InputEmail />
        <InputLocation />
        <button onClick={this.join}>Participar</button>
      </form>
    </div>;
  },

  join: function(e) {
    // TODO
    e.preventDefault();
  }
});

module.exports = HeroSignup;
