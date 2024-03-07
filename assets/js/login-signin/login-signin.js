$(document).ready(function () {
  const showAlert = (alertType, message) => {
    $(".alert").addClass(alertType).text(message);
    setTimeout(() => {
      $(".alert").removeClass(alertType).text("");
    }, 2000);
  };

  $("#frmLogin").submit(function (e) {
    e.preventDefault();
    var username = $("#username").val();
    var password = $("#password").val();

    if (/\s/.test(username)) {
      $("#username").addClass("is-invalid");
    }

    if (password.trim() === "") {
      $("#password").addClass("is-invalid");
    }

    if (
      !$("#username").hasClass("is-invalid") &&
      !$("#password").hasClass("is-invalid")
    ) {
      $.ajax({
        type: "POST",
        url: "backend/endpoints/global/login.php",
        data: {
          username: username,
          password: password,
        },
        success: function (response) {
          if (response == "200") {
            showAlert("alert-success", "Login Success!");
            setTimeout(() => {
              window.location.href = "login-success.php";
            }, 2000);
          } else {
            showAlert("alert-danger", "Incorrect Username or Password!");
          }
        },
        error: function (error) {
          console.log(error);
        },
      });
    }
  });

  //---------------------------

  $("#frmSignin").submit(function (e) {
    e.preventDefault();

    $(".form-control").removeClass("is-invalid");

    var name = $("#sName").val();
    var email = $("#sEmail").val();
    var contactNo = $("#sContactNo").val();
    var username = $("#sUsername").val();
    var password = $("#sPassword").val();
    var address = $("#sAddress").val();
    var validId = $("#sValidId").val();

    // Validate Email
    if (email.trim() === "" || !isValidEmail(email)) {
      $("#sEmail").addClass("is-invalid");
    }

    // Validate Contact Number
    if (contactNo.trim() === "" || !isValidContactNo(contactNo)) {
      $("#sContactNo").addClass("is-invalid");
    }

    // Validate Username
    if (/\s/.test(username) || username.length < 7) {
      $("#sUsername").addClass("is-invalid");
    }

    // Validate Password
    if (password.trim() === "" || password.length < 7) {
      $("#sPassword").addClass("is-invalid");
    }

    // Validate Address
    if (address.trim() === "" || address.length < 15) {
      $("#sAddress").addClass("is-invalid");
    }

    if (validId.trim() === "") {
      $("#sValidId").addClass("is-invalid");
    }
  });

  function isValidEmail(email) {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  }

  function isValidContactNo(contactNo) {
    return /^\d{11}$/.test(contactNo);
  }
});
