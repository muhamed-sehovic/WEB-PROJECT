var UserService = {
  init: function () {
      const token = localStorage.getItem("user_token");
      if (token && token !== "undefined") {
          return window.location.replace("index.html");
      }

      $("#loginForm").on("submit", function (e) {
          e.preventDefault();

          const entity = {
              email: $("#loginEmail").val(),
              password: $("#loginPassword").val(),
              rememberMe: $("#rememberMe").is(":checked")
          };

          UserService.login(entity);
      });

      $("#registerForm").on("submit", function (e) {
          e.preventDefault();

          const password = $("#registerPassword").val();
          const confirmPassword = $("#registerConfirmPassword").val();

          if (password !== confirmPassword) {
              return toastr.error("Passwords do not match!");
          }

          const entity = {
              name: $("#registerName").val(),
              surname: $("#registerSurname").val(),
              email: $("#registerEmail").val(),
              birth_date: $("#registerBirthDate").val(),
              address: $("#registerAddress").val(),
              phone: $("#registerPhone").val(),
              password: password
          };

          UserService.register(entity);
      });
  },

  login: function (entity) {
      toastr.info("Logging in...");

      $.ajax({
          url: `${Constants.PROJECT_BASE_URL}auth/login`,
          type: "POST",
          data: JSON.stringify(entity),
          contentType: "application/json",
          dataType: "json",
          success: function (result) {
              localStorage.setItem("user_token", result.data.token);
              toastr.success("Login successful!");
              setTimeout(() => {
                  window.location.replace("index.html");
              }, 1500);
          },
          error: function (xhr) {
              let errorMsg = "Login failed. Please try again.";
              try {
                  const parsed = JSON.parse(xhr.responseText);
                  errorMsg = parsed.message || errorMsg;
              } catch (e) {
                  errorMsg = xhr.responseText;
              }
              toastr.error(errorMsg);
          }
      });
  },

  register: function (entity) {
      toastr.info("Registering...");

      $.ajax({
          url: `${Constants.PROJECT_BASE_URL}auth/register`,
          type: "POST",
          data: JSON.stringify(entity),
          contentType: "application/json",
          dataType: "json",
          success: function () {
              toastr.success("Registration successful! Redirecting to login...");
              setTimeout(() => {
                  window.location.replace("login.html");
              }, 2000);
          },
          error: function (xhr) {
              let errorMsg = "Registration failed.";
              try {
                  const parsed = JSON.parse(xhr.responseText);
                  errorMsg = parsed.message || errorMsg;
              } catch (e) {
                  errorMsg = xhr.responseText;
              }
              toastr.error(errorMsg);
          }
      });
  },

  logout: function () {
      localStorage.removeItem("user_token");
      toastr.info("You have been logged out.");
      setTimeout(() => {
          window.location.replace("login.html");
      }, 1000);
  }
};
