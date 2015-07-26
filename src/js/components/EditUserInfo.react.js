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

  renderInputOccupation: function() {
    return <Input
      className="signup-input signup-input-occupation"
      name="occupation"
      onChange={this.onChange}
      placeholder="Profissão"
      type="text"
      value={this.state.occupation}
      />;
  },

  renderInputSchool: function() {
    return <Input
      className="signup-input signup-input-school"
      name="school"
      onChange={this.onChange}
      placeholder="Instituição de ensino"
      type="text"
      value={this.state.school}
      />;
  },

  renderInputCourse: function() {
    return <Input
      className="signup-input signup-input-course"
      name="course"
      onChange={this.onChange}
      placeholder="Curso"
      type="text"
      value={this.state.course}
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
        <h2>Conte-nos mais sobre você</h2>
        <form>
          {this.renderInputName()}
          {this.renderInputPhone()}
          {this.renderInputBirthday()}
          {this.renderInputOccupation()}
          {this.renderInputSchool()}
          {this.renderInputCourse()}
          {this.renderButton()}
        </form>
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
