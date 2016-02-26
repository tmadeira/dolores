"use strict";

var React = require("react");

var Lightbox = require("./Lightbox.react");

var StreamingLightbox = React.createClass({
  getInitialState: function() {
    return {
      show: true
    };
  },

  hide: function() {
    this.setState({
      show: false
    });
  },

  render: function() {
    if (!this.state.show) {
      return null;
    }

    var lightboxContent = (
      <div className="lightbox-content">
        <h2 className="signin-text">
          <span>Acompanhe ao vivo!</span>
        </h2>
        <p className="streaming-lightbox-text">
          {this.props.title}
        </p>
        <p className="streaming-lightbox-text">
          <a className="streaming-lightbox-button" href="/streaming/">
            <span>Clique aqui para assistir</span>
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

module.exports = StreamingLightbox;
