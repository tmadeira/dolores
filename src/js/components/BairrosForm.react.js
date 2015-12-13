"use strict";

var _ = require("lodash");
var React = require("react");

var API = require("../api");

var Input = require("./Input.react");

var BairrosForm = React.createClass({
  getInitialState: function() {
    return {
      location: "",
      suggestions: {
        location: []
      }
    };
  },

  onChange: function(name, value, suggestion) {
    var dict = {};
    dict[name] = value;
    this.setState(dict);
    if (suggestion) {
      this.onSubmit();
    } else {
      this.getSuggestions(name, value);
    }
  },

  onSubmit: function() {
    window.DoloresAuthenticator.signIn(null, null, {
      location: this.state.location
    });
    // TODO: DoloresAuthenticator.signIn must use given location
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
    return <form className="temas-form-form" onSubmit={this.onSubmit}>
      <Input
        className="tema-form-item bairros-form-location"
        name="location"
        onChange={this.onChange}
        placeholder="Bairro (ou município, caso não seja capital)"
        suggestions={this.state.suggestions.location}
        type="text"
        value={this.state.location}
      />
    </form>;
  }
});

module.exports = BairrosForm;
