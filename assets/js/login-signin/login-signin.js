$(document).ready(function () {
  const isValidEmail = (email) => {
    return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
  };

  const isValidContactNo = (contactNo) => {
    return /^\d{11}$/.test(contactNo);
  };

  const validateSignUp = (
    email,
    contactNo,
    address,
    username,
    password,
    validId
  ) => {
    var numberOfInvalid = 0;

    // Validate Email
    if (email.trim() === "" || !isValidEmail(email)) {
      $("#sEmail").addClass("is-invalid");
      numberOfInvalid++;
    }

    // Validate Contact Number
    if (contactNo.trim() === "" || !isValidContactNo(contactNo)) {
      $("#sContactNo").addClass("is-invalid");
      numberOfInvalid++;
    }
    
    // Validate Address
    if (address.trim() === "" || address.length < 15) {
      $("#sAddress").addClass("is-invalid");
      numberOfInvalid++;
    }

    // Validate Username
    if (/\s/.test(username) || username.length < 7) {
      $("#sUsername").addClass("is-invalid");
      numberOfInvalid++;
    }

    // Validate Password
    if (password.trim() === "" || password.length < 7) {
      $("#sPassword").addClass("is-invalid");
      numberOfInvalid++;
    }

    if (validId.trim() === "") {
      $("#sValidId").addClass("is-invalid");
      numberOfInvalid++;
    }

    if (numberOfInvalid > 0) {
      return false;
    } else {
      return true;
    }
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
            Swal.fire({
              icon: 'success',
              title: 'Login Success!',
              showConfirmButton: false,
              timer: 2000
            }).then(() => {
              window.location.href = "login-success.php";
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Incorrect Username or Password!',
              showConfirmButton: false,
              timer: 2000
            });
          }
        },
        error: function (error) {
          console.log(error);
        },
      });
    }
  });

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

    var formData = new FormData($(this)[0]);

    if (
      validateSignUp(email, contactNo, address, username, password, validId)
    ) {
      $.ajax({
        type: "POST",
        url: "backend/endpoints/global/signup.php",
        data: formData,
        contentType: false,
        processData: false,
        success: function (response) {
          console.log(response);
          if (response == "200") {
            Swal.fire({
              icon: 'success',
              title: 'Sign In Success!',
              showConfirmButton: false,
              timer: 2000
            }).then(() => {
              window.location.href = "login.php";
            });
          } else if (response == "404") {
            $("#sUsername").addClass("is-invalid");
            Swal.fire({
              icon: 'error',
              title: 'Username already exists!',
              showConfirmButton: false,
              timer: 2000
            });
          } else {
            Swal.fire({
              icon: 'error',
              title: 'Something Went Wrong!',
              showConfirmButton: false,
              timer: 2000
            });
          }
        },
      });
    } else {
      Swal.fire({
        icon: 'error',
        title: 'Invalid Sign In!',
        showConfirmButton: false,
        timer: 2000
      });
    }
  });
});