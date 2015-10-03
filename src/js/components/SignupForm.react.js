"use strict";

var _ = require("lodash");
var React = require("react");

var API = require("../api");
var validate = require("../validate");

var Input = require("./Input.react");

var SignupForm = React.createClass({
  getInitialState: function() {
    return {
      name: this.props.data.name,
      email: this.props.data.email,
      phone: this.props.data.phone,
      errors: {},
      suggestions: {
        location: []
      },
      schema: {
        email: ["isNonEmpty", "isValidEmail"],
        location: ["isNonEmpty", "isValidLocation"]
      }
    };
  },

  onBlur: function(name) {
    this.validate([name]);
  },


  onChange: function(name, value) {
    var dict = {};
    dict[name] = value;
    this.setState(dict);
    if (name in this.state.suggestions) {
      this.getSuggestions(name, value);
    }
  },

  setError: function(name, error) {
    var errors = this.state.errors;
    errors[name] = error;
    this.setState({errors: errors});
  },

  validate: function(fields) {
    var errors = this.state.errors;

    for (var i = 0; i < fields.length; i++) {
      var name = fields[i];
      if (name in this.state.schema) {
        errors[name] = null;
        validate(
          name,
          this.state[name],
          this.state.schema[name],
          this.setError
        );
      }
    }

    this.setState({errors: errors});
  },

  getSuggestions: _.debounce(function(name, value) {
    var params = {key: name, value: value};
    API.route("suggest").get(params).done(function(data) {
      var suggestions = this.state.suggestions;
      suggestions[name] = data.suggestions;
      this.setState({suggestions: suggestions});
    }.bind(this));
  }, 150, {maxWait: 600}),

  render: function() {
    return (
      <form>
        <div className="signup-form">
          {this.renderInputName()}
          {this.renderInputEmail()}
          {this.renderInputPhone()}
          {this.renderInputLocation()}
          {this.renderButton()}
        </div>
      </form>
    );
  },

  renderInputName: function() {
    return <Input
      className="signup-input signup-input-name"
      disabled={true}
      name="name"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Nome completo"
      type="text"
      value={this.state.name}
      />;
  },

  renderInputPhone: function() {
    return <Input
      className="signup-input signup-input-phone"
      error={this.state.errors.phone}
      mask="phone"
      name="phone"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Telefone (WhatsApp)"
      type="text"
      value={this.state.phone}
      />;
  },

  renderInputEmail: function() {
    return <Input
      className="signup-input signup-input-email"
      error={this.state.errors.email}
      name="email"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="E-mail"
      type="text"
      value={this.state.email}
      />;
  },

  renderInputLocation: function() {
    return <Input
      className="signup-input signup-input-location"
      error={this.state.errors.location}
      name="location"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Bairro (ou município, caso não seja capital)"
      suggestions={this.state.suggestions.location}
      type="text"
      value={this.state.location}
      />;
  },

  renderButton: function() {
    return (
      <button
          className="signup-button"
          type="submit"
          >
        Participar
      </button>
    );
  }
});

module.exports = SignupForm;
