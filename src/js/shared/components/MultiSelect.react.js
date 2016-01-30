"use strict";

var _ = require("lodash");
var React = require("react");
var cx = require("classnames");

var MultiSelect = React.createClass({
  getInitialState: function() {
    return {
      focused: false
    };
  },

  render: function() {
    var className = cx(this.props.className, {
      empty: this.props.selected.length === 0,
      focused: this.state.focused
    });
    return (
      <div className={className}>
        {this.renderIcon()}
        {this.renderPrivacy()}
        {this.renderInput()}
        {this.props.selected.map(this.renderInputHidden)}
        {this.renderOptions()}
        {this.renderButton()}
        {this.renderValidation()}
      </div>
    );
  },

  renderButton: function() {
    if (!this.state.focused) {
      return null;
    }

    var onClick = function() {
      this.setState({focused: false});
    }.bind(this);

    return (
      <button className="multi-select-done" onClick={onClick}>
        <i className="fa fa-check"></i>
      </button>
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
    var onFocus = function() {
      this.setState({focused: true});
    }.bind(this);

    return <input
        className="multi-select-selected"
        onFocus={onFocus}
        placeholder={this.props.placeholder}
        readOnly={true}
        ref="input"
        type="text"
        value={this.props.selected.join(", ")}
        />;
  },

  renderInputHidden: function(option) {
    var name = this.props.name + "[]";
    var value = "valueMap" in this.props ? this.props.valueMap[option] : option;
    return <input type="hidden" name={name} key={option} value={value} />;
  },

  renderOptions: function() {
    return (
      <ul className="multi-select-options">
        {this.props.options.map(this.renderOption)}
      </ul>
    );
  },

  renderOption: function(option) {
    var selected = _.indexOf(this.props.selected, option) !== -1;

    var className = {
      selected: selected
    };

    var checkmark = {
      "fa": true,
      "fa-fw": true,
      "fa-lg": true,
      "fa-check-square": selected,
      "fa-square-o": !selected,
      "check": true
    };

    var onOptionClick = function(e) {
      this.props.onToggle(this.props.name, option);
      e.preventDefault();
    }.bind(this);

    return (
      <li key={option} onClick={onOptionClick} className={cx(className)}>
        <i className={cx(checkmark)}></i>
        <span>{option}</span>
      </li>
    );
  },

  renderValidation: function() {
    if (!this.props.error) {
      return null;
    }

    return <div className="validation-error">{this.props.error}</div>;
  }
});

module.exports = MultiSelect;
