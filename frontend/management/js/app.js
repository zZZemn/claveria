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
          $(".modal").modal("hide");
          showAlert("alert-success", "Schedule Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
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
          $(".modal").modal("hide");
          showAlert("alert-success", "Route Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#frmAddSubRoute").submit(function (e) {
    e.preventDefault();
    // var origin = $("#addSROrigin").val();
    // var destination = $("#addSRDestination").val();
    // var fare = $("#addSRFare").val();
    // console.log("Hey");
    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        console.log(response);
        if (response == "200") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Sub Route Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#frmAddBus").submit(function (e) {
    e.preventDefault();
    // var plateNumber = $("#addBusPlateNumber").val();

    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        if (response == "200") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Bus Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else if (response == "400") {
          showAlert("alert-danger", "Plate number is already existing.");
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#frmAddAnnouncement").submit(function (e) {
    e.preventDefault();
    // var title = $("#addAnnouncementTitle").val();
    // var text = $("#addAnnouncementText").val();

    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        if (response == "200") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Announcement Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#MarkAsPaid").click(function (e) {
    e.preventDefault();
    var bookingId = $(this).data("id");

    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: {
        bookingId: bookingId,
        submitType: "MarkAsPaid",
      },
      success: function (response) {
        if (response == "200") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Booking Paid!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#frmAddBooking").submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        console.log(response);
        if (response != "404") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Booking Success!");
          setTimeout(() => {
            window.location.href = "booking-details.php?b_id=" + response;
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#frmAddNewBooking").submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        console.log(response);
        if (response != "404") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Booking Success!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  // --------------------------
  $("#frmAddInspector").submit(function (e) {
    e.preventDefault();

    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: formData,
      success: function (response) {
        console.log(response);
        if (response == "200") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Inspector Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else if (response == "404") {
          showAlert("alert-danger", "Username is already existing.");
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  checkWindowSize();
});
