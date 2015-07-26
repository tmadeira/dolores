"use strict";

var React = require("react");

var EditUserInfo = React.createClass({
  getInitialState: function() {
    return {
      name: ""
    };
  },

  renderInputName: function() {
    return <input
      className="signup-input signup-input-name"
      onChange={this.setName}
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
  }
});

module.exports = EditUserInfo;
