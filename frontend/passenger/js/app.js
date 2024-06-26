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

  const isValidEmail = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  };

  const isValidContactNo = (contactNo) => {
    return /^\d{11}$/.test(contactNo);
  };

  const validateEditProfile = (email, contactNo, username, address) => {
    var numberOfInvalid = 0;

    // Validate Email
    if (email.trim() === "" || !isValidEmail(email)) {
      $("#editEmail").addClass("is-invalid");
      numberOfInvalid++;
    }

    // Validate Contact Number
    if (contactNo.trim() === "" || !isValidContactNo(contactNo)) {
      $("#editContact").addClass("is-invalid");
      numberOfInvalid++;
    }

    // Validate Username
    if (/\s/.test(username) || username.length < 7) {
      $("#editUsername").addClass("is-invalid");
      numberOfInvalid++;
    }

    // Validate Address
    if (address.trim() === "" || address.length < 15) {
      $("#editAddress").addClass("is-invalid");
      numberOfInvalid++;
    }

    if (numberOfInvalid > 0) {
      return false;
    } else {
      return true;
    }
  };

  $("#frmEditProfile").submit(function (e) {
    e.preventDefault();

    var name = $("#editName").val();
    var email = $("#editEmail").val();
    var contactNo = $("#editContact").val();
    var username = $("#editUsername").val();
    var address = $("#editAddress").val();

    var formData = new FormData($(this)[0]);

    if (validateEditProfile(email, contactNo, username, address)) {
      $.ajax({
        type: "POST",
        url: "../../backend/endpoints/passenger/post.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          if (response == "200") {
            showAlert("alert-success", "Profile Edited!");
            setTimeout(() => {
              window.location.reload();
            }, 2000);
          } else if (response == "404") {
            $("#sUsername").addClass("is-invalid");
            showAlert("alert-danger", "Username si already exist!");
          } else {
            showAlert("alert-danger", "Something Went Wrong!");
          }
        },
      });
    } else {
      showAlert("alert-danger", "Invalid Info!");
    }
  });

  $("#frmAddBooking").submit(function (e) {
    e.preventDefault();

    var formData = new FormData($(this)[0]);

    $.ajax({
      type: "POST",
      url: "../../backend/database/book.php",
      data: formData,
      contentType: false,
      processData: false,
      success: function (response) {
        console.log(response);
        if (response == "200") {
          showAlert("alert-success", "Booking Success!");
          setTimeout(() => {
            window.location.reload();
          }, 2000);
        } else if (response == "201") {
          showAlert("alert-success", "Seat Added!");
          setTimeout(() => {
            window.location.reload();
          }, 2000);
        } else if (response == "404") {
          showAlert("alert-danger", "Booking Failed");
        } else {
          showAlert("alert-danger", "Something Went Wrong!");
        }
      },
    });
  });

  $(".btnDelete").click(function (e) {
    e.preventDefault();
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/passenger/post.php",
      data: {
        submitType: "DeleteBooking",
        id: $(this).data("id"),
      },
      success: function (response) {
        console.log(response);
        if (response == "200") {
          showAlert("alert-success", "Booking Deleted!");
          setTimeout(() => {
            window.location.reload();
          }, 2000);
        } else {
          showAlert("alert-danger", "Something Went Wrong!");
        }
      },
    });
  });

  $(".btnEditBooking").click(function (e) {
    e.preventDefault();
    console.log($(this).data("sr_id"));
    console.log($(this).data("discount_id"));
    console.log($(this).data("seat_no"));

    $("#editSelectRoute").val($(this).data("sr_id"));
    $("#editSelectDiscount").val($(this).data("discount_id"));
    $("#editSelectSeat").val($(this).data("seat_no"));
    $("#editBookingId").val($(this).data("id"));

    $("#EditBooking").modal("show");
  });

  $("#frmEditBooking").submit(function (e) {
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
          showAlert("alert-success", "Booking Edited!");
          window.location.reload();
        } else {
          showAlert("alert-danger", "Something Went Wrong.");
        }
      },
    });
  });

  $("#cancelBooking").click(function (e) {
    e.preventDefault();
    var id = $(this).data("id");
    $.ajax({
      type: "POST",
      url: "../../backend/endpoints/management/post.php",
      data: {
        submitType: "cancelBooking",
        id: id,
      },
      success: function (response) {
        console.log(response);
        if (response == "200") {
          showAlert("alert-success", "Booking Cancelled!");
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
