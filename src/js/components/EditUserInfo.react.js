"use strict";

var $ = require("jquery");
var React = require("react");

var API = require("../api");

var Input = require("./Input.react");

var EditUserInfo = React.createClass({
  getInitialState: function() {
    return {
      loading: false,
      isSent: false,
      errors: {}
    };
  },

  renderInputName: function() {
    return <Input
      className="signup-input signup-input-name"
      error={this.state.errors.full_name}
      name="full_name"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Nome"
      type="text"
      value={this.state.full_name}
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

  renderInputBirthdate: function() {
    return <Input
      className="signup-input signup-input-birthdate"
      error={this.state.errors.birthdate}
      mask="date"
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
      name="school"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Instituição de ensino"
      type="text"
      value={this.state.school}
      />;
  },

  renderInputCourse: function() {
    return <Input
      className="signup-input signup-input-course"
      error={this.state.errors.course}
      name="course"
      onBlur={this.onBlur}
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

  renderSuccess: function() {
    if (!this.state.isSent) {
      return null;
    }

    return (
      <div className="success">
        <p>Muito obrigado por participar do <strong>Se A Cidade Fosse
        Nossa</strong>! Nos próximos meses, teremos encontros presenciais nos
        bairros e sobre vários temas da cidade. Além disso, em breve teremos a
        segunda versão de nossa plataforma online, onde você poderá opinar e
        propor políticas para a cidade. Enviaremos para o seu e-mail
        atualizações sobre todo o processo.</p>
        <p>Forte Abraço,<br />
        Equipe Se A Cidade Fosse Nossa</p>

        <button className="signup-button" onClick={this.props.close}>
          Fechar
        </button>
      </div>
    );
  },

  renderForm: function() {
    if (this.state.isSent) {
      return null;
    }

    return (
      <form ref="form" onSubmit={this.submit}>
        {this.renderInputName()}
        {this.renderInputPhone()}
        {this.renderInputBirthdate()}
        {this.renderInputOccupation()}
        {this.renderInputSchool()}
        {this.renderInputCourse()}
        {this.renderButton()}
      </form>
    );
  },

  render: function() {
    var title = this.state.isSent ?
      "Muito obrigado!" :
      "Conte-nos mais sobre você";

    return (
      <div className="lightbox-edit-user-info">
        <h2>{title}</h2>
        {this.renderSuccess()}
        {this.renderForm()}
      </div>
    );
  },

  onBlur: function(name) {
    var errors = this.state.errors;
    errors[name] = null;
    this.setState({errors: errors});
  },

  onChange: function(name, value) {
    var dict = {};
    dict[name] = value;
    this.setState(dict);
  },

  setError: function(name, error) {
    var errors = this.state.errors;
    errors[name] = error;
    this.setState({errors: errors});
  },

  submit: function(e) {
    this.setState({
      loading: true
    });

    var form = $(React.findDOMNode(this.refs.form));
    var params = form.serialize();

    API.route("user_info").post(params).done(function() {
      this.setState({
        loading: false,
        isSent: true
      });
    }.bind(this)).fail(function(data) {
      switch (data.status) {
        case 400:
          for (var key in data.responseJSON) {
            if (data.responseJSON.hasOwnProperty(key)) {
              this.setError(key, data.responseJSON[key]);
            }
          }
          break;
        default:
          alert("Erro ao efetuar cadastro: " + data.responseJSON.error);
      }
      this.setState({
        loading: false
      });
    }.bind(this));

    e.preventDefault();
  }
});

module.exports = EditUserInfo;
