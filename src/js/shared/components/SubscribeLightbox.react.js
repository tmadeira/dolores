"use strict";

var _ = require("lodash");
var $ = require("jquery");
var React = require("react");

var API = require("../api");
var validate = require("../validate");

var Input = require("./Input.react");
var Lightbox = require("./Lightbox.react");

var SubscribeLightbox = React.createClass({
  getInitialState: function() {
    return {
      show: true,
      name: "",
      email: "",
      phone: "",
      errors: {},
      waiting: false,
      suggestions: {
        location: []
      },
      schema: {
        name: ["isNonEmpty"],
        location: ["isNonEmpty", "isValidLocation"]
      }
    };
  },

  hide: function() {
    this.setState({
      show: false
    });
    return false;
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
    e.preventDefault();

    this.setState({
      waiting: true
    });

    var request = {
      check: "1",
      name: this.state.name,
      email: this.state.email,
      phone: this.state.phone,
      location: this.state.location,
      origin: "Lightbox"
    };

    API.route("subscribe").post({data: request}).done(function(response) {
      console.log("Subscribe done", response);
      this.hide();
    }.bind(this)).fail(function(data) {
      this.setState({
        waiting: false
      });
      switch (data.status) {
        case 400:
          if ("formErrors" in data.responseJSON) {
            console.log(data.responseJSON.formErrors);
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
  },

  renderForm: function() {
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
          {this.renderInputName()}
          {this.renderInputLocation()}
          {this.renderInputPhone()}
          {this.renderInputEmail()}
          {this.renderButton()}
        </div>
      </form>
    );
  },

  render: function() {
    if (!this.state.show) {
      return null;
    }

    var lightboxContent = (
      <div className="lightbox-content">
        <h3 className="subscribe-lightbox-call">É de Porto Alegre? Cadastre-se para ficar por dentro do nosso movimento!</h3>
        {this.renderForm()}
        <div className="subscribe-lightbox-form-close">
          <a onClick={this.hide} href="#">Não quero me cadastrar. Seguir para o site &raquo;</a>
        </div>
      </div>
    );

    return (
      <Lightbox close={this.hide}>
        {lightboxContent}
      </Lightbox>
    );
  },

  renderInputName: function() {
    return <Input
      className="signup-input signup-input-name"
      error={this.state.errors.name}
      focusOnMount={true}
      icon="user"
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
      placeholder={window.doloresConfig.strings.locationPlaceholder}
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

module.exports = SubscribeLightbox;
