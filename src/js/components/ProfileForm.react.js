"use strict";

var _ = require("lodash");
var $ = require("jquery");
var React = require("react");

var API = require("../api");
var validate = require("../validate");

var Input = require("./Input.react");
var MultiSelect = require("./MultiSelect.react");

var sanitizePhone = function(phone) {
  phone = phone.replace(/[^0-9]/g, "");
  if (phone.length === 10) {
    return "(" + phone.substring(0, 2) + ") " + phone.substring(2, 6) + "-" +
      phone.substring(6, 10);
  } else if (phone.length === 11) {
    return "(" + phone.substring(0, 2) + ") " + phone.substring(2, 7) + "-" +
      phone.substring(7, 11);
  }
  return phone;
};

var sanitizeDate = function(date) {
  var parts = date.split("-");
  if (parts.length !== 3) {
    return "";
  }
  return parts[2] + "/" + parts[1] + "/" + parts[0];
};

var ProfileForm = React.createClass({
  getInitialState: function() {
    return {
      name: this.props.data.name,
      email: this.props.data.email,
      phone: sanitizePhone(this.props.data.phone),
      birthdate: sanitizeDate(this.props.data.birthdate),
      occupation: this.props.data.occupation,
      school: this.props.data.school,
      course: this.props.data.course,
      errors: {},
      interests: this.props.data.interests,
      collaboration: this.props.data.collaboration,
      waiting: false,
      suggestions: {
        location: []
      },
      schema: {
        email: ["isNonEmpty", "isValidEmail"],
        location: ["isNonEmpty", "isValidLocation"]
      },
      options: {
        interests: [
          "Democratização da Comunicação",
          "Direitos Humanos",
          "Educação",
          "Meio Ambiente",
          "Moradia",
          "Planejamento Urbano",
          "Saúde",
          "Segurança Pública",
          "Transparência e Participação",
          "Transporte"
        ],
        collaboration: [
          "Design",
          "Fotografia",
          "Ilustração",
          "Mobilização de rua",
          "Motion Graphics",
          "Pesquisa",
          "Programação",
          "Redação",
          "Redes sociais",
          "Vídeo",
          "Web Design"
        ]
      }
    };
  },

  renderInputName: function() {
    return <Input
      className="signup-input signup-input-name"
      disabled={true}
      icon="user"
      name="name"
      placeholder="Nome completo"
      type="text"
      value={this.state.name}
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

  renderInputPhone: function() {
    return <Input
      className="signup-input signup-input-phone"
      error={this.state.errors.phone}
      mask="phone"
      icon="phone"
      name="phone"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Telefone (WhatsApp)"
      type="text"
      value={this.state.phone}
      />;
  },

  renderInputBirthdate: function() {
    return <Input
      className="signup-input signup-input-birthdate"
      error={this.state.errors.birthdate}
      mask="date"
      icon="birthday-cake"
      name="birthdate"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Data de nascimento"
      type="type"
      value={this.state.birthdate}
      />;
  },

  renderInputOccupation: function() {
    return <Input
      className="signup-input signup-input-occupation"
      error={this.state.errors.occupation}
      icon="suitcase"
      name="occupation"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Profissão"
      type="text"
      value={this.state.occupation}
      />;
  },

  renderInputSchool: function() {
    return <Input
      className="signup-input signup-input-school"
      error={this.state.errors.school}
      icon="university"
      name="school"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Instituição de ensino / Movimento"
      type="text"
      value={this.state.school}
      />;
  },

  renderInputCourse: function() {
    return <Input
      className="signup-input signup-input-course"
      error={this.state.errors.course}
      icon="graduation-cap"
      name="course"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Curso"
      type="text"
      value={this.state.course}
      />;
  },

  renderInputInterests: function() {
    return <MultiSelect
      className="signup-input signup-input-interests"
      error={this.state.errors.interests}
      icon="heart"
      name="interests"
      onToggle={this.onToggle}
      options={this.state.options.interests}
      placeholder="Áreas de interesse"
      selected={this.state.interests}
      />;
  },

  renderInputCollaboration: function() {
    return <MultiSelect
      className="signup-input signup-input-collaboration"
      error={this.state.errors.collaboration}
      icon="group"
      name="collaboration"
      onToggle={this.onToggle}
      options={this.state.options.collaboration}
      placeholder="Quer colaborar? Quais seus talentos?"
      selected={this.state.collaboration}
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
    if (this.state.waiting) {
      var spinner = "fa fa-refresh fa-spin fa-4x";
      return (
        <div>
          <p style={{textAlign: "center"}}><i className={spinner}></i></p>
          <p style={{textAlign: "center"}}>Carregando...</p>
        </div>
      );
    }

    /*
        {this.renderInputName()}
        {this.renderInputEmail()}
        {this.renderInputLocation()}
        {this.renderInputPhone()}
    */

    return (
      <form ref="form" onSubmit={this.submit}>
        {this.renderInputBirthdate()}
        {this.renderInputOccupation()}
        {this.renderInputSchool()}
        {this.renderInputCourse()}
        {this.renderInputInterests()}
        {this.renderInputCollaboration()}
        {this.renderButton()}
      </form>
    );
  },

  onBlur: function(name) {
    this.validate([name]);
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

  onChange: function(name, value) {
    var dict = {};
    dict[name] = value;
    this.setState(dict);
    if (name in this.state.suggestions) {
      this.getSuggestions(name, value);
    }
  },

  getSuggestions: _.debounce(function(name, value) {
    var params = {key: name, value: value};
    API.route("suggest").get(params).done(function(data) {
      var suggestions = this.state.suggestions;
      suggestions[name] = data.suggestions;
      this.setState({suggestions: suggestions});
    }.bind(this));
  }, 150, {maxWait: 600}),

  onToggle: function(name, value) {
    var selected = this.state[name];

    var idx = _.indexOf(selected, value);
    if (idx !== -1) {
      selected.splice(idx, 1);
    } else {
      selected.push(value);
    }

    var state = {};
    state[name] = selected;
    this.setState(state);
  },

  setError: function(name, error) {
    var errors = this.state.errors;
    errors[name] = error;
    this.setState({errors: errors});
  },

  submit: function(e) {
    this.setState({
      waiting: true
    });

    var form = $(React.findDOMNode(this.refs.form));
    var params = form.serialize();

    API.route("userinfo").post(params).done(function(data) {
      if (data.action === "refresh") {
        this.props.refreshCallback();
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
  }
});

module.exports = ProfileForm;
