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

function updateURLParameter(url, param, paramVal) {
  var newAdditionalURL = "";
  var tempArray = url.split("?");

  var baseURL = tempArray[0];
  var additionalURL = tempArray[1];
  var temp = "";
  if (additionalURL) {
    tempArray = additionalURL.split("&");
    for (var i = 0; i < tempArray.length; i++) {
      if (tempArray[i].split("=")[0] != param) {
        newAdditionalURL += temp + tempArray[i];
        temp = "&";
      }
    }
  }
  //+ window.location.hash
  var rows_txt = temp + "" + param + "=" + paramVal;
  return baseURL + "?" + newAdditionalURL + rows_txt + window.location.hash;
}

function getIdSelections() {
  return $.map($table.bootstrapTable("getSelections"), function (row) {
    return row.id;
  });
}

function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.id, selections) !== -1;
  });
  return res;
}

function detailFormatter(index, row) {
  var html = [];
  $.each(row, function (key, value) {
    html.push("<p><b>" + key + ":</b> " + value + "</p>");
  });
  return html.join("");
}

function operateFormatter(value, row, index) {
  return [
    '<a class="like" href="javascript:void(0)" title="Like">',
    '<i class="fa fa-heart"></i>',
    "</a>  ",
    '<a class="remove" href="javascript:void(0)" title="Remove">',
    '<i class="fa fa-trash"></i>',
    "</a>",
  ].join("");
}

window.operateEvents = {
  "click .like": function (e, value, row, index) {
    alert("You click like action, row: " + JSON.stringify(row));
  },
  "click .remove": function (e, value, row, index) {
    $table.bootstrapTable("remove", {
      field: "id",
      values: [row.id],
    });
  },
};

function totalTextFormatter(data) {
  return "Total";
}

function totalNameFormatter(data) {
  return data.length;
}

function totalPriceFormatter(data) {
  var field = this.field;
  return (
    "$" +
    data
      .map(function (row) {
        return +row[field].substring(1);
      })
      .reduce(function (sum, i) {
        return sum + i;
      }, 0)
  );
}

function responseHandler(res) {
  $.each(res.rows, function (i, row) {
    row.state = $.inArray(row.id, selections) !== -1;
  });
  return res;
}

function CheckboxDetailedView() {
  if ($("#CheckboxDetailedView").is(":checked")) {
    document.cookie = "detailView=true";
  } else {
    document.cookie = "detailView=false";
  }
  location.reload();
}

function GetDetailedViewState() {
  let detailView = "detailView=";
  let decodedCookie = decodeURIComponent(document.cookie);
  let ca = decodedCookie.split(";");
  var isdetailView = "";
  for (let i = 0; i < ca.length; i++) {
    let c = ca[i];
    while (c.charAt(0) == " ") {
      c = c.substring(1);
    }
    if (c.indexOf(detailView) == 0) {
      isdetailView = c.substring(detailView.length, c.length);
    }
  }
  if (isdetailView == "") {
    document.cookie = "detailView=true";
    return "true";
  }

  return isdetailView;
}

function CustomViews(PHPScript) {
  isdetailView = GetDetailedViewState();

  var url = new URL(window.location);
  var ViewGetParam = url.searchParams.get("View");

  const div = document.querySelector(".dropdown-menu");
  CustomViewJson = JSON.parse(this.responseText);
  const ViewsArray = [];
  jQuery.each(CustomViewJson, function (i, val) {
    ViewsArray.push(i);
  });
  ViewCheck = false;

  for (let index = 0; index < ViewsArray.length; index++) {
    if (ViewsArray[index] == ViewGetParam) {
      ViewCheck = true;
    }

    div.innerHTML += `<a class="dropdown-item" onclick="loadFile('${PHPScript}', initTableViewCustom, '${ViewsArray[index]}');" >${ViewsArray[index]}</a>`;
  }
  if (ViewCheck == false) {
    ViewGetParam = "Main";
  }

  if (isdetailView == "true") {
    $("#table").attr("data-detail-view", "true");
    $("#table").attr("data-reorderable-columns", "false");
    $("#CheckboxDetailedView").prop("checked", true);
  } else {
    $("#table").attr("data-detail-view", "false");
    $("#table").attr("data-reorderable-columns", "true");
    $("#CheckboxDetailedView").prop("checked", false);
  }

  loadFile(PHPScript, initTableViewCustom, ViewGetParam);
}
