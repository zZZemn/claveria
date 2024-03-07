$(document).ready(function () {
  var sideNavState = false;

  function checkWindowSize() {
    var windowWidth = $(window).width();
    if (windowWidth >= 900) {
      $(".side-bar").css("transform", "translateX(0)");
      sideNavState = true;
    } else {
      $(".side-bar").css("transform", "translateX(-100%)");
      sideNavState = false;
    }
  }

  $("#toggleSideBar").click(function (e) {
    e.preventDefault();
    if (sideNavState) {
      $(".side-bar").css("transform", "translateX(-100%)");
    } else {
      $(".side-bar").css("transform", "translateX(0)");
    }
    sideNavState = !sideNavState;
  });

  $(window).resize(function () {
    checkWindowSize();
  });

  checkWindowSize();
});
