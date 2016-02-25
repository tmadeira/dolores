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
      waiting: false,
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
    this.setState({
      waiting: true
    });
    var params = {
      auth: this.props.data.auth,
      name: this.state.name,
      email: this.state.email,
      phone: this.state.phone,
      location: this.state.location
    };
    API.route("signup").post({data: params}).done(function(data) {
      if (data.action === "refresh") {
        this.props.refreshCallback("signup");
      } else {
        console.log("Unexpected return", data);
        this.setState({
          waiting: false
        });
      }
    }.bind(this)).fail(function(data) {
      this.setState({
        waiting: false
      });
      switch (data.status) {
        case 400:
          if ("formErrors" in data.responseJSON) {
            for (var key in data.responseJSON.formErrors) {
              if (data.responseJSON.formErrors.hasOwnProperty(key)) {
                this.setError(key, data.responseJSON.formErrors[key]);
              }
            }
          }
          break;
        default:
          alert("Erro ao efetuar cadastro: " + data.responseJSON.error);
      }
    }.bind(this));
    e.preventDefault();
  },

  render: function() {
    if (this.state.waiting) {
      var spinner = "fa fa-refresh fa-spin fa-4x";
      return (
        <div>
          <p style={{textAlign: "center"}}><i className={spinner}></i></p>
          <p style={{textAlign: "center"}}>Carregando...</p>
        </div>
      );
    }
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
      privacy="everyone"
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
      privacy="me"
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
      privacy="me"
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
      placeholder={window.doloresConfig.strings.locationPlaceholder}
      privacy="everyone"
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
        <span>Cadastrar</span>
      </button>
    );
  }
});

module.exports = SignupForm;
