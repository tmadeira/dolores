"use strict";

var _ = require("lodash");
var $ = require("jquery");
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

  submit: function(e) {
    var form = $(React.findDOMNode(this.refs.form));
    var params = form.serialize();
    console.log(params);
    alert("Em construção.");
    e.preventDefault();
  },

  render: function() {
    return (
      <form ref="form" onSubmit={this.submit}>
        <div className="signup-form">
          {this.renderLogo()}
          {this.renderInputName()}
          {this.renderInputEmail()}
          {this.renderInputPhone()}
          {this.renderInputLocation()}
          {this.renderButton()}
        </div>
      </form>
    );
  },

  renderLogo: function() {
    return <div className="signup-logo"></div>;
  },

  renderInputName: function() {
    var authIcon = "user";
    if (this.props.data.auth.type === "facebook") {
      authIcon = "facebook-square";
    } else if (this.props.data.auth.type === "google") {
      authIcon = "google-plus-square";
    }
    return <Input
      className="signup-input signup-input-name"
      disabled={true}
      icon={authIcon}
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
      icon="phone"
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
      icon="envelope"
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
      icon="map-marker"
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
        Cadastrar
      </button>
    );
  }
});

module.exports = SignupForm;
