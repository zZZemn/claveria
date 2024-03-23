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

  $(".btn-add-passenger").click(function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $("#addPassengerRouteId").text(id);
    $("#subRouteId").val(id);
    $("#AddPassenger").modal("show");
  });

  $("#frmAddInspector").submit(function (e) {
    e.preventDefault();
    var formData = $(this).serialize();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/inspector/post.php",
      data: formData,
      success: function (response) {
        console.log(response);
        if (response == "200") {
          $(".modal").modal("hide");
          showAlert("alert-success", "Passenger Added!");
          setTimeout(() => {
            window.location.reload();
          }, 1000);
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  checkWindowSize();
});
