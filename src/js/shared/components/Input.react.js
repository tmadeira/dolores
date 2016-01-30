"use strict";

var _ = require("lodash");
var $ = require("jquery");
var React = require("react");
var cx = require("classnames");

require("jquery.maskedinput");

var sanitizeString = function(str) {
  str = str.toLowerCase();
  str = str.trim();

  var map = {
    a: /[\xE0-\xE6]/g,
    e: /[\xE8-\xEB]/g,
    i: /[\xEC-\xEF]/g,
    o: /[\xF2-\xF6]/g,
    u: /[\xF9-\xFC]/g,
    c: /\xE7/g,
    n: /\xF1/g
  };

  for (var letter in map) {
    str = str.replace(map[letter], letter);
  }

  return str;
};

var stringsMatch = function(a, b) {
  return sanitizeString(a) === sanitizeString(b);
};

var Input = React.createClass({
  getInitialState: function() {
    return {
      focused: false,
      selectedSuggestion: null
    };
  },

  componentDidMount: function() {
    var input = $(React.findDOMNode(this.refs.input));
    switch (this.props.mask) {
      case "date":
        input.mask("99/99/9999");
        break;
      case "phone":
        input.focusout(function() {
          $(this).unmask();
          var value = $(this).val().replace(/\D/g, "");
          if (value.length > 10) {
            $(this).mask("(99) 99999-999?9");
          } else {
            $(this).mask("(99) 9999-9999?9");
          }
        }).trigger("focusout");
        break;
    }
    if (this.props.focusOnMount) {
      input.focus();
    }
  },

  render: function() {
    var className = cx(this.props.className, {
      focused: this.state.focused,
      empty: !this.props.value
    });
    return (
      <div className={className}>
        {this.renderIcon()}
        {this.renderPrivacy()}
        {this.renderInput()}
        {this.renderSuggestions()}
        {this.renderValidation()}
      </div>
    );
  },

  renderIcon: function() {
    if (!("icon" in this.props)) {
      return null;
    }
    var className = {
      "fa": true,
      "fa-fw": true,
      "fa-lg": true,
      "icon": true
    };
    className["fa-" + this.props.icon] = true;
    return <i className={cx(className)}></i>;
  },

  renderPrivacy: function() {
    if (!("privacy" in this.props)) {
      return null;
    }

    var icon = (this.props.privacy === "me" ? "lock" : "globe");

    var className = {
      "fa": true,
      "fa-fw": true,
      "privacy": true
    };
    className["fa-" + icon] = true;
    return <i className={cx(className)}></i>;
  },

  renderInput: function() {
    var onBlur = _.debounce(function() {
      var value = React.findDOMNode(this.refs.input).value;
      this.props.onChange(this.props.name, value);
      if (this.props.onBlur) {
        this.props.onBlur(this.props.name);
      }
      this.setState({
        focused: false,
        selectedSuggestion: null
      });
    }.bind(this), 100);

    var onChange = function(e) {
      this.props.onChange(this.props.name, e.target.value);
    }.bind(this);

    var onFocus = function() {
      this.setState({focused: true});
    }.bind(this);

    var blur = function() {
      React.findDOMNode(this.refs.input).blur();
    }.bind(this);

    var useSuggestion = function() {
      if (this.props.suggestions.length === 0) {
        return;
      }
      var index = this.state.selectedSuggestion;
      if (!_.isNumber(index)) {
        if (this.props.suggestions.length === 1) {
          index = 0;
        } else {
          for (var i = 0; i < this.props.suggestions.length; i++) {
            if (stringsMatch(this.props.value, this.props.suggestions[i])) {
              index = i;
              break;
            }
          }
        }
      }
      if (_.isNumber(index)) {
        this.props.onChange(
          this.props.name,
          this.props.suggestions[index],
          true
        );
      }
      blur();
    }.bind(this);

    var setSuggestion = function(delta) {
      var mod = this.props.suggestions.length;
      var newIndex;
      if (_.isNumber(this.state.selectedSuggestion)) {
        newIndex = (this.state.selectedSuggestion + mod + delta) % mod;
      } else {
        if (delta > 0) {
          newIndex = delta - 1;
        } else {
          newIndex = (mod + delta) % mod;
        }
      }
      this.setState({
        selectedSuggestion: newIndex
      });
    }.bind(this);

    var onKey = function(e) {
      if (this.props.suggestions) {
        switch (e.which) {
          case 13: // Enter
            useSuggestion();
            e.preventDefault();
            break;
          case 27: // Esc
            blur();
            e.preventDefault();
            break;
          case 40: // Down
            setSuggestion(1);
            e.preventDefault();
            break;
          case 38: // Up
            setSuggestion(-1);
            e.preventDefault();
            break;
        }
      }
    }.bind(this);

    return <input
        disabled={this.props.disabled}
        name={this.props.name}
        onBlur={onBlur}
        onChange={onChange}
        onFocus={onFocus}
        onKeyDown={onKey}
        type={this.props.type}
        placeholder={this.props.placeholder}
        ref="input"
        value={this.props.value}
        />;
  },

  renderSuggestions: function() {
    if (!this.props.suggestions) {
      return null;
    }

    return <ul className="suggestions">
      {this.props.suggestions.map(this.renderSuggestion)}
    </ul>;
  },

  renderSuggestion: function(suggestion, index) {
    var className = cx({selected: index === this.state.selectedSuggestion});

    return (
      <li key={suggestion} onClick={this.onSuggestionClick}
          className={className}>
        {suggestion}
      </li>
    );
  },

  onSuggestionClick: function(e) {
    this.props.onChange(this.props.name, e.target.innerHTML, true);
  },

  renderValidation: function() {
    if (!this.props.error) {
      return null;
    }

    return <div className="validation-error">{this.props.error}</div>;
  }
});

module.exports = Input;
