$(document).ready(function () {
  var sideNavState = false;

  const showAlert = (alertType, message) => {
    $(".alert").addClass(alertType).text(message);
    setTimeout(() => {
      $(".alert").removeClass(alertType).text("");
    }, 2000);
  };

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

  // --------------------------
  $("#frmAddRouteSched").submit(function (e) {
    e.preventDefault();
    // var route = $("#addRoute").val();
    // var bus = $("#addBus").val();
    // var departure = $("#addDeparture").val();
    // var arrival = $("#addArrival").val();

    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        if (response == "200") {
          $('.modal').modal('hide');
          showAlert("alert-success", "Schedule Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-success", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#frmAddRoute").submit(function (e) {
    e.preventDefault();
    // var origin = $("#addROrigin").val();
    // var destination = $("#addRDestination").val();
    // var fare = $("#addRFare").val();

    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        if (response == "200") {
          $('.modal').modal('hide');
          showAlert("alert-success", "Route Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-success", "Something Went Wrong.");
        }
      },
    });
  });

  checkWindowSize();
});
