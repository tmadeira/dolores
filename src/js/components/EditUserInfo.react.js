"use strict";

var React = require("react");

var Input = require("./Input.react");

var EditUserInfo = React.createClass({
  getInitialState: function() {
    return {};
  },

  renderInputName: function() {
    return <Input
      className="signup-input signup-input-name"
      name="name"
      onChange={this.onChange}
      placeholder="Nome"
      type="text"
      value={this.state.name}
      />;
  },

  renderButton: function() {
    return (
      <button className="signup-button" type="submit">
        Enviar
      </button>
    );
  },

  render: function() {
    return (
      <div className="lightbox-edit-user-info">
        {this.renderInputName()}
        {this.renderButton()}
      </div>
    );
  },

  onChange: function(name, value) {
    var dict = {};
    dict[name] = value;
    this.setState(dict);
  }
});

module.exports = EditUserInfo;
