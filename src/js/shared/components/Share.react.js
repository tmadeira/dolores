"use strict";

var React = require("react");

var Lightbox = require("./Lightbox.react");

var Share = React.createClass({
  getInitialState: function() {
    return {
      show: location.hash === "#share"
    };
  },

  hide: function() {
    location.hash = "";
    this.setState(this.getInitialState());
  },

  render: function() {
    if (!this.state.show) {
      return null;
    }

    var shareUrl = location.protocol + "//" + location.host + location.pathname;
    var fbUrl = "https://www.facebook.com/sharer/sharer.php?u=" + shareUrl;
    var ttUrl = "https://twitter.com/share?url=" + shareUrl;

    var lightboxContent = (
      <div className="lightbox-content">
        <h2 className="signin-text">
          <span>Proposta enviada!</span>
        </h2>
        <p className="signin-text">
          Que tal compartilhar sua ideia com seus amigos?
        </p>
        <p className="signin-text">
          <a className="social-button share-facebook"
              href={fbUrl}
              target="_blank">
            <i className="fa fa-fw fa-lg fa-facebook"></i>
            Compartilhar
          </a>
          <a className="social-button share-twitter"
              href={ttUrl}
              target="_blank">
            <i className="fa fa-fw fa-lg fa-twitter"></i>
            Tuitar
          </a>
        </p>
      </div>
    );

    return (
      <Lightbox close={this.hide}>
        {lightboxContent}
      </Lightbox>
    );
  }
});

module.exports = Share;
