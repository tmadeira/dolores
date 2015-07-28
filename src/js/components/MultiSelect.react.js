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
    var className = cx(this.props.className, {focused: this.state.focused});
    return (
      <div className={className}>
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

    return <button className="multi-select-done" onClick={onClick}>✓</button>;
  },

  renderInput: function() {
    var onFocus = function() {
      this.setState({focused: true});
    }.bind(this);

    var placeholder = this.state.focused ?
      "Clique nas opções para selecionar" :
      this.props.placeholder;

    return <input
        className="multi-select-selected"
        onFocus={onFocus}
        placeholder={placeholder}
        readOnly={true}
        ref="input"
        type="text"
        value={this.props.selected.join(", ")}
        />;
  },

  renderInputHidden: function(option) {
    var name = this.props.name + "[]";
    return <input type="hidden" name={name} key={option} value={option} />;
  },

  renderOptions: function() {
    return (
      <ul className="multi-select-options">
        {this.props.options.map(this.renderOption)}
      </ul>
    );
  },

  renderOption: function(option) {
    var className = cx({
      selected: _.indexOf(this.props.selected, option) !== -1
    });
    return (
      <li key={option} onClick={this.onOptionClick} className={className}>
        {option}
      </li>
    );
  },

  renderValidation: function() {
    if (!this.props.error) {
      return null;
    }

    return <div className="validation-error">{this.props.error}</div>;
  },

  onOptionClick: function(e) {
    this.props.onToggle(this.props.name, e.target.innerHTML);
    e.preventDefault();
  }
});

module.exports = MultiSelect;
