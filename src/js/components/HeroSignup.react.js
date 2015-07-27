"use strict";

var $ = require("jquery");
var React = require("react");
var cx = require("classnames");

var API = require("../api");
var validate = require("../validate");

var EditUserInfo = require("./EditUserInfo.react");
var Input = require("./Input.react");

var HeroSignup = React.createClass({
  getInitialState: function() {
    return {
      loading: false,
      isSent: false,
      errors: {},
      schema: {
        email: ["isNonEmpty", "isValidEmail"],
        location: ["isNonEmpty", "isValidLocation"]
      }
    };
  },

  render: function() {
    return (
      <div className="wrap">
        <form ref="form" onSubmit={this.submit}>
          {this.renderBasic()}
        </form>
        {this.renderMore()}
      </div>
    );
  },

  renderInputEmail: function() {
    return <Input
      className="signup-input signup-input-email"
      disabled={this.state.isSent}
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
      disabled={this.state.isSent}
      error={this.state.errors.location}
      name="location"
      onBlur={this.onBlur}
      onChange={this.onChange}
      placeholder="Bairro (ou município, caso não seja capital)"
      suggestions={[]}
      type="text"
      value={this.state.location}
      />;
  },

  renderButton: function() {
    var className = cx({
      "signup-button": true,
      "is-basic-sent": this.state.isSent
    });
    return (
      <button
          className={className}
          disabled={this.state.loading}
          type="submit"
          >
        Participar
      </button>
    );
  },

  renderBasic: function() {
    return <div className="basic-form">
      {this.renderInputEmail()}
      {this.renderInputLocation()}
      {this.renderButton()}
    </div>;
  },

  renderMore: function() {
    if (this.state.isSent) {
      var overlayClick = function(e) {
        if (e.target.className === "lightbox-overlay-tablet") {
          this.closeLightbox();
        }
      }.bind(this);

      return (
        <div className="lightbox-overlay-tablet" onClick={overlayClick}>
          <EditUserInfo close={this.closeLightbox} />
        </div>
      );
    } else {
      return null;
    }
  },

  closeLightbox: function() {
    this.setState({
      email: "",
      location: "",
      isSent: false
    });
  },

  onBlur: function(name) {
    this.validate([name]);
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
      errors[name] = null;
      validate(name, this.state[name], this.state.schema[name], this.setError);
    }

    this.setState({errors: errors});
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

    var form = $(React.findDOMNode(this.refs.form));
    var params = form.serialize();

    API.route("signup").post(params).done(function() {
      this.setState({
        loading: false,
        isSent: true
      });
    }.bind(this)).fail(function(data) {
      switch (data.status) {
        case 400:
          console.log("400", data.responseJSON);
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

module.exports = HeroSignup;
