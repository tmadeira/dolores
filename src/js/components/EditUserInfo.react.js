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

  renderInputPhone: function() {
    return <Input
      className="signup-input signup-input-phone"
      mask="phone"
      name="phone"
      onChange={this.onChange}
      placeholder="Telefone (WhatsApp)"
      type="text"
      value={this.state.phone}
      />;
  },

  renderInputBirthday: function() {
    return <Input
      className="signup-input signup-input-birthday"
      mask="date"
      name="birthday"
      onChange={this.onChange}
      placeholder="Data de nascimento"
      type="type"
      value={this.state.birthday}
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
        {this.renderInputPhone()}
        {this.renderInputBirthday()}
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
