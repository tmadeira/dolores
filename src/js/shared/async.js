"use strict";

var include = function(id, url) {
  var js, fjs = document.getElementsByTagName("script")[0];
  if (document.getElementById(id)) {
    return;
  }
  js = document.createElement("script");
  js.id = id;
  js.src = url;
  js.async = 1;
  fjs.parentNode.insertBefore(js, fjs);
};

module.exports = {
  include: include
};
