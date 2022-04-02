function SidebarCollapse() {
  $("li").click(function (href) {
    try {
      if (href.target.href.includes("#togglesidebar")) {
      } else {
        $("li").removeClass("active");
        $(this).addClass("active");
      }
    } catch (error) {}
  });

  $("#prodTabs").on("click", ".tablink, a", function (e) {
    e.preventDefault();

    var url = $(this).attr("data-url");

    href = this.hash;

    if (href !== "#togglesidebar" && href !== "#submenu") {
      window.location.hash = href;
      loadFile(url, displayContent);
    }
  });

  $("#dismiss, .overlay").on("click", function () {
    // hide sidebar
    $("#sidebar").removeClass("active");
    // hide overlay
    $(".overlay").removeClass("active");
  });

  $("#sidebarCollapse").on("click", function () {
    $("#sidebar").toggleClass("active");

    if ($("#sidebar").hasClass("active")) {
      $("#content").width($(window).width() - (100 + 58));
      //$(sticky-header-container)
    } else {
      $("#content").width($(window).width() - (250 + 58));
    }
  });
}

function SetProfilePhoto($user, $Element) {
  if ($user.photo) {
    try {
     
      if ($user.photo !== ""  && $user.photo.length > 20) {
        $("#" + $Element).attr("src", "data:image/png;base64," + $user.photo);
        $("#" + $Element).css("display", "inline");
      }
    } catch (error) {}
  }
}

