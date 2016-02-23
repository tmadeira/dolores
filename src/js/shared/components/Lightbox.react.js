"use strict";

var React = require("react");

var Lightbox = React.createClass({
  containerClick: function(e) {
    if (e.target.className === "lightbox-cell") {
      this.props.close();
    }
  },

  render: function() {
    return (
      <div className="lightbox-overlay">
        <div className="lightbox-table">
          <div className="lightbox-cell" onClick={this.containerClick}>
            <div className="lightbox">
              <button className="lightbox-close" onClick={this.props.close}>
                X
              </button>
              {this.props.children}
            </div>
          </div>
        </div>
      </div>
    );
  }
});

module.exports = Lightbox;
