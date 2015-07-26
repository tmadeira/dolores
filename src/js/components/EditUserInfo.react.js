"use strict";

var React = require("react");

var API = require("../api");

var Input = require("./Input.react");

var EditUserInfo = React.createClass({
  getInitialState: function() {
    return {
      isSent: false
    };
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
      <form onSubmit={this.submit}>
        {this.renderInputName()}
        {this.renderInputPhone()}
        {this.renderInputBirthday()}
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

  onChange: function(name, value) {
    var dict = {};
    dict[name] = value;
    this.setState(dict);
  },

  submit: function(e) {
    this.setState({
      loading: true
    });

    API.route("test").get({"hello": "world"}).done(function() {
      this.setState({
        loading: false,
        isSent: true
      });
    }.bind(this));

    e.preventDefault();
  }
});

module.exports = EditUserInfo;
