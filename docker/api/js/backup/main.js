function xhrSuccess() {
  this.callback.apply(this, this.arguments);
}

function xhrError() {
  console.error(this.statusText);
}

function loadFile(url, callback) {
  var xhr = new XMLHttpRequest();
  xhr.callback = callback;
  xhr.arguments = Array.prototype.slice.call(arguments, 2);
  xhr.onload = xhrSuccess;
  xhr.onerror = xhrError;
  xhr.open("GET", url, true);
  xhr.setRequestHeader("Cache-Control", "no-cache");
  xhr.setRequestHeader("Currentuser", $user.Domain + "\\" + $user.User);
  xhr.send(null);
}

function SendPost(url, Post, callback) {
  var xhr = new XMLHttpRequest();
  xhr.callback = callback;
  xhr.arguments = Array.prototype.slice.call(arguments, 2);
  xhr.onload = xhrSuccess;
  xhr.onerror = xhrError;
  xhr.open("POST", url, true);
  xhr.setRequestHeader("Cache-Control", "no-cache");
  xhr.setRequestHeader("Currentuser", $user.Domain + "\\" + $user.User);
  xhr.send(Post);
}

function removeParam(parameter) {
  var url = document.location.href;
  var urlparts = url.split("?");

  if (urlparts.length >= 2) {
    var urlBase = urlparts.shift();
    var queryString = urlparts.join("?");

    var prefix = encodeURIComponent(parameter) + "=";
    var pars = queryString.split(/[&;]/g);
    for (var i = pars.length; i-- > 0; )
      if (pars[i].lastIndexOf(prefix, 0) !== -1) pars.splice(i, 1);
    url = urlBase + "?" + pars.join("&");
    window.history.pushState("", document.title, url); // added this line to push the new url directly to url bar .
  }
  return url;
}

function getParameterByName(name, url = window.location.href) {
  name = name.replace(/[\[\]]/g, "\\$&");
  var regex = new RegExp("[?&]" + name + "(=([^&#]*)|&|#|$)"),
    results = regex.exec(url);
  if (!results) return null;
  if (!results[2]) return "";
  return decodeURIComponent(results[2].replace(/\+/g, " "));
}

function DeleteAllGetParam() {
  const queryString = window.location;
  const urlParams = new URLSearchParams(queryString.search);
  var URLsize = getParameterByName("size");
  var URLCustomView = getParameterByName("View");
  var returnValue = "";

  if (URLsize == "All") {
    urlParams.delete("size");
    history.replaceState(null, "", "?" + urlParams + queryString.hash);
  }
  if (URLCustomView) {
    returnValue = URLCustomView;
  } else {
    returnValue = "Main";
  }
  return returnValue;
}
