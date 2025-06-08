$(document).ready(function () {
    var app = $.spapp({
        defaultView: "#home",
        templateDir: "pages/"
    });

    app.route({ view: "home", load: "home.html" });
    app.route({ view: "about", load: "about.html" });
    app.route({ view: "contact", load: "contact.html" });
    // app.route({ view: "equipment", load: "equipment.html" });
    app.route({ view: "reservations", load: "reservations.html" });
    app.route({ view: "faq", load: "faq.html" });
    app.route({ view: "studio-overview", load: "studio-overview.html" });
    app.route({ view: "account", load: "account.html" });
    app.route({ view: "admin-login", load: "admin-login.html" });
    app.route({ view: "register", load: "register.html" });
    app.route({ view: "customer-dashboard", load: "customer-dashboard.html" });
    app.route({ view: "admin-dashboard", load: "admin-dashboard.html" });
    app.route({
        view: "equipment",
        load: "equipment.html",
        onCreate: function () {
            EquipmentService.getAll(function (equipmentList) {
                const tbody = $("#equipmentTable tbody");
                tbody.empty();

                equipmentList.forEach(e => {
                    tbody.append(`
                        <tr>
                            <td>${e.category}</td>
                            <td>${e.model}</td>
                            <td>${e.description}</td>
                        </tr>
                    `);
                });
            });
        }
    });

    

    app.run();

    // Toastr Notification Setup
    toastr.options = {
        closeButton: true,
        progressBar: true,
        positionClass: "toast-top-right",
        timeOut: "3000"
    };

//     // Handle Login Form Submission
// $(document).on("submit", "#loginForm", function (event) {
//     event.preventDefault(); // Prevent actual form submission

//     var email = $("#loginEmail").val().trim();
//     var password = $("#loginPassword").val().trim();

//     if (email && password) {
//         toastr.success("Login successful! Redirecting...", "Success");
//         setTimeout(function () {
//             window.location.href = "#customer-dashboard"; // Redirect to customer dashboard
//         }, 1500);
//     } else {
//         toastr.error("Please fill in both fields.", "Login Failed");
//     }
// });

// $(document).ready(function () {
//     $(document).on("click", "#logoutBtn", function () {
//         toastr.info("Logging out...", "Logout");
//         setTimeout(function () {
//             window.location.hash = "#account"; // Redirect to login page
//         }, 1000);
//     });
// });


// // Handle Admin Login Form Submission
// $(document).on("submit", "#adminLoginForm", function (event) {
//     event.preventDefault(); // Prevent actual form submission

//     var adminId = $("#adminId").val().trim();
//     var email = $("#adminEmail").val().trim();
//     var securityKey = $("#securityKey").val().trim();
//     var password = $("#adminPassword").val().trim();

//     if (adminId && email && securityKey && password) {
//         toastr.success("Admin login successful! Redirecting...", "Success");
//         setTimeout(function () {
//             window.location.href = "#admin-dashboard"; // Redirect to admin dashboard
//         }, 1500);
//     } else {
//         toastr.error("Please fill in all fields.", "Login Failed");
//     }
// });

// $(document).ready(function () {
//     $(document).on("click", "#logoutAdminBtn", function () {
//         toastr.info("Logging out...", "Logout");
//         setTimeout(function () {
//             window.location.hash = "#admin-login"; // Redirect to login page
//         }, 1000);
//     });
// });




    // // Handle Registration Form Submission
    // $(document).on("submit", "#registerForm", function (event) {
    //     event.preventDefault(); // Prevent actual form submission

    //     var name = $("#registerName").val().trim();
    //     var surname = $("#registerSurname").val().trim();
    //     var email = $("#registerEmail").val().trim();
    //     var birthDate = $("#registerBirthDate").val().trim(); // Ensure it matches the HTML ID exactly
    //     var address = $("#registerAddress").val().trim();
    //     var phone = $("#registerPhone").val().trim();
    //     var password = $("#registerPassword").val().trim();
    //     var confirmPassword = $("#registerConfirmPassword").val().trim();

    //     if (!name || !surname || !email || !birthDate || !address || !phone || !password || !confirmPassword) {
    //         toastr.error("Please fill in all fields.", "Registration Failed");
    //         return;
    //     }

    //     if (password !== confirmPassword) {
    //         toastr.error("Passwords do not match.", "Registration Failed");
    //         return;
    //     }

    //     toastr.success("Registration successful! Redirecting to login...", "Success");
    //     setTimeout(function () {
    //         window.location.hash = "#account"; // Redirect to login page after registration
    //     }, 1500);
    // });


    
    // Handle Contact Form Submission
    $(document).on("submit", "#contactForm", function (event) {
        event.preventDefault(); // Prevent actual form submission

        var name = $("#contactName").val().trim();
        var email = $("#contactEmail").val().trim();
        var phone = $("#contactPhone").val().trim();
        var message = $("#contactMessage").val().trim();

        if (name === "" || email === "" || phone === "" || message === "") {
            toastr.error("Please fill in all fields.", "Submission Failed");
            return;
        }

        // Simulate form submission
        setTimeout(function () {
            toastr.success("Your message has been sent successfully!", "Success");
            $("#contactForm")[0].reset(); // Reset form fields
        }, 500);
    });
});

// // Handle Resevation Form Submission
// $(document).on("submit", "#reservationForm", function (event) {
//     event.preventDefault(); // Prevent actual form submission

//     var name = $("#reservationName").val().trim();
//     var surname = $("#reservationSurname").val().trim();
//     var email = $("#reservationEmail").val().trim();
//     var phone = $("#reservationPhone").val().trim();
//     var category = $("#reservationCategory").val().trim();
//     var date = $("#reservationDate").val().trim();
//     var time = $("#reservationTime").val().trim();

//     if (name === "" || surname === "" || email === "" || phone === "" || category === "" || date === "" || time === "") {
//         toastr.error("Please fill in all fields.", "Submission Failed");
//         return;
//     }

//     // Simulate form submission
//     setTimeout(function () {
//         toastr.success("Your reservation has been sent successfully!", "Success");
//         $("#reservationForm")[0].reset(); // Reset form fields
//     }, 500);
// });


// // Toastr for Customer Dashboard
// function cancelReservation() {
//     toastr.success('Reservation canceled successfully!');
//     $('#cancelModal').modal('hide');
// }

// function saveProfile() {
//     toastr.success('Profile updated successfully!');
// }
// function makeReservation() {
//     toastr.success('Reservation added successfully!');
//     $('#makeReservationModal').modal('hide');
// }
// function updateReservation() {
//     toastr.success('Reservation updated successfully!');
//     $('#updateReservationModal').modal('hide');
// }
// function deactivateProfile() {
//     toastr.success('Profile deactivated successfully!');
//     $('#deactivateProfileModal').modal('hide');
// }



// Toastr for Admin Dashboard
function addUser() {
    toastr.success('User added successfully!');
    $('#addUserModal').modal('hide');
}

function editUser() {
    toastr.info('User updated successfully!');
    $('#editUserModal').modal('hide');
}

function removeUser() {
    toastr.error('User removed successfully!');
    $('#removeUserModal').modal('hide');
}

function addReservation() {
    toastr.success('Reservation added successfully!');
    $('#addReservationModal').modal('hide');
}

function editReservation() {
    toastr.info('Reservation updated successfully!');
    $('#editReservationModal').modal('hide');
}

function removeReservation() {
    toastr.error('Reservation removed successfully!');
    $('#removeReservationModal').modal('hide');
}

function addEquipment() {
    toastr.success('Equipment added successfully!');
    $('#addEquipmentModal').modal('hide');
}

function editEquipment() {
    toastr.info('Equipment updated successfully!');
    $('#editEquipmentModal').modal('hide');
}

function removeEquipment() {
    toastr.error('Equipment removed successfully!');
    $('#removeEquipmentModal').modal('hide');
}

$(document).on("click", "#logoutBtn", function (e) {
    e.preventDefault();
    UserService.logout();
  });
  
  
    // Attach logout button event only if dashboard page is loaded
    if ($("#logoutBtn").length) {
      $("#logoutBtn").on("click", function (e) {
        e.preventDefault();
        UserService.logout();
      });
    }
  ;
// Delegate click event for admin logout button
$(document).on("click", "#logoutAdminBtn", function (e) {
    e.preventDefault();
    UserService.adminLogout();
});

// Attach admin logout button event only if admin dashboard page is loaded and button exists
if ($("#logoutAdminBtn").length) {
    $("#logoutAdminBtn").on("click", function (e) {
        e.preventDefault();
        UserService.adminLogout();
    });
}



$(document).ready(function () {
    // User "My Account" link click handler
    $('a[href="#account"]').on('click', function (e) {
      const userToken = localStorage.getItem("user_token");
      if (userToken && userToken !== "undefined") {
        e.preventDefault();
        window.location.hash = "#customer-dashboard";
      }
    });
  
    // Admin "Admin Login" link click handler
    $('a[href="#account"]').on('click', function (e) {
      const adminToken = localStorage.getItem("admin_token");
      if (adminToken && adminToken !== "undefined") {
        e.preventDefault();
        window.location.hash = "#admin-dashboard";
      }
    });
  });

  $(document).on("click", "#saveProfileBtn", function (e) {
    e.preventDefault();

    const updatedUser = {
        first_name: $("#dash_first_name").val(),
        last_name: $("#dash_last_name").val(),
        email: $("#dash_email").val(),
        birth_date: $("#dash_birth_date").val(),
        address: $("#dash_address").val(),
        phone: $("#dash_phone").val()
    };

    UserService.updateUserProfile(updatedUser);
});


  