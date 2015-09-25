"use strict";

var React = require("react");

var Authenticator = React.createClass({
  getInitialState: function() {
    return {
      token: {},
      clientInfo: {},
      serverInfo: {}
    };
  },

  componentWillMount: function() {
    window.DoloresAuthenticator = {
      setToken: function(token) {
        this.setState({
          token: token
        });
      }.bind(this),

      hasToken: function(type) {
        return "type" in this.state.token && this.state.token.type === type;
      }.bind(this)
    };
  },

  hasToken: function() {
    return "type" in this.state.token;
  },

  hasServerInfo: function() {
    return "email" in this.state.serverInfo &&
      "location" in this.state.serverInfo;
  },

  render: function() {
    if (this.hasToken()) {
      if (this.hasServerInfo()) {
        /* User is logged in. */
        window.location.reload();
        return null;
      } else {
        /* We have a token from Google or Facebook.
         * TODO: request user information (email and location) */
      }
    } else {
      /* We don't have anything. */
    }

    return <div></div>;
  }
});

module.exports = Authenticator;
