"use strict";

var $ = require("jquery");
var React = require("react");

require("jquery.maskedinput");

var API = require("../api");

var Lightbox = require("./Lightbox.react");

var SubscribeLightbox = React.createClass({
  getInitialState: function() {
    return {
      show: true,
      name: "",
      email: "",
      phone: "",
      location: ""
    };
  },

  componentDidMount: function() {
    $("#subscribe-lightbox-name").focus();
    $("#subscribe-lightbox-phone").focusout(function() {
      $(this).unmask();
      var value = $(this).val().replace(/\D/g, "");
      if (value.length > 10) {
        $(this).mask("(99) 99999-999?9");
      } else {
        $(this).mask("(99) 9999-9999?9");
      }
    }).trigger("focusout");
  },

  hide: function() {
    this.setState({
      show: false
    });
    return false;
  },

  submit: function() {
    var request = {
      name: this.state.name,
      email: this.state.email,
      phone: this.state.phone,
      location: this.state.location,
      origin: "Lightbox"
    };

    API.route("subscribe").post({data: request}).done(function(response) {
      console.log("Subscribe done", response);
    }).fail(function(respose) {
      console.log("Subscribe failed", response);
    });

    this.hide();
    return false;
  },

  render: function() {
    if (!this.state.show) {
      return null;
    }

    var change = function(e) {
      var st = {};
      st[e.target.name] = e.target.value;
      this.setState(st);
    }.bind(this);

    var lightboxContent = (
      <div className="lightbox-content">
        <form className="subscribe-lightbox-form" onSubmit={this.submit}>
          <h3 className="subscribe-lightbox-call">Cadastre-se para ficar por dentro do movimento Compartilhe a Mudança!</h3>
          <div className="subscribe-lightbox-form-item">
            <label><span className="label">Nome</span>
              <input
                className="subscribe-lightbox-form-input"
                onBlur={change}
                onChange={change}
                id="subscribe-lightbox-name"
                type="text"
                name="name"
                placeholder="Seu nome"
                value={this.state.name}
                />
            </label>
          </div>
          <div className="subscribe-lightbox-form-item">
            <label><span className="label">E-mail</span>
              <input
                className="subscribe-lightbox-form-input"
                onBlur={change}
                onChange={change}
                type="text"
                name="email"
                placeholder="Seu e-mail"
                value={this.state.email}
                />
            </label>
          </div>
          <div className="subscribe-lightbox-form-item">
            <label><span className="label">Telefone</span>
              <input
                className="subscribe-lightbox-form-input"
                onBlur={change}
                onChange={change}
                id="subscribe-lightbox-phone"
                type="text"
                name="phone"
                placeholder="Seu telefone (WhatsApp)"
                value={this.state.phone}
                />
            </label>
          </div>
          <div className="subscribe-lightbox-form-item">
            <label><span className="label">Bairro</span>
              <input
                className="subscribe-lightbox-form-input"
                onBlur={change}
                onChange={change}
                type="text"
                name="location"
                placeholder="Seu bairro"
                value={this.state.location}
                />
            </label>
          </div>
          <div className="subscribe-lightbox-form-item">
            <input type="hidden" name="origin" value="Lightbox" />
            <button className="subscribe-lightbox-form-button" type="submit">
              Cadastrar
            </button>
          </div>
          <div className="subscribe-ligthbox-form-response">
            {this.state.response}
          </div>
          <div className="subscribe-lightbox-form-close">
            <a onClick={this.hide} href="#">Não quero me cadastrar. Seguir para o site &raquo;</a>
          </div>
        </form>
      </div>
    );

    return (
      <Lightbox close={this.hide}>
        {lightboxContent}
      </Lightbox>
    );
  }
});

module.exports = SubscribeLightbox;
