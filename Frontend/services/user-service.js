var UserService = {
    init: function () {
        const userToken = localStorage.getItem("user_token");
        const adminToken = localStorage.getItem("admin_token");

        // Redirect user or admin if already logged in
        if (userToken && userToken !== "undefined" && window.location.pathname.includes("account")) {
            return window.location.replace("index.html");
        }

        if (adminToken && adminToken !== "undefined" && window.location.pathname.includes("admin-login")) {
            return window.location.replace("admin-dashboard.html");
        }

        // User login form
        $("#loginForm").on("submit", function (e) {
            e.preventDefault();

            const entity = {
                email: $("#loginEmail").val(),
                password: $("#loginPassword").val(),
                rememberMe: $("#rememberMe").is(":checked")
            };

            UserService.login(entity);
        });

        // Admin login form
        $("#adminLoginForm").on("submit", function (e) {
            e.preventDefault();

            const entity = {
                email: $("#adminEmail").val(),
                password: $("#adminPassword").val()
            };

            UserService.adminLogin(entity);
        });

        // Registration form
        $("#registerForm").on("submit", function (e) {
            e.preventDefault();

            const password = $("#registerPassword").val();
            const confirmPassword = $("#registerConfirmPassword").val();

            if (password !== confirmPassword) {
                return toastr.error("Passwords do not match!");
            }

            const entity = {
                first_name: $("#registerName").val(),
                last_name: $("#registerSurname").val(),
                email: $("#registerEmail").val(),
                birth_date: $("#registerBirthDate").val(),
                address: $("#registerAddress").val(),
                phone: $("#registerPhone").val(),
                password: password
            };

            UserService.register(entity);
        });

        // Load profile data if on dashboard or profile page
        if (userToken && window.location.hash === "#customer-dashboard") {
            UserService.loadUserProfile();
        }

        // Save profile changes on form submit (assuming form id="profileForm")
        $("#profileForm").on("submit", function (e) {
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
                    window.location.hash = "#customer-dashboard";
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

    adminLogin: function (entity) {
        toastr.info("Logging in as admin...");

        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}auth/login`,
            type: "POST",
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function (result) {
                const data = result.data;

                // Check if user is admin
                if (!data.isAdmin || data.isAdmin !== 1) {
                    return toastr.error("Access denied: this user is not an admin.");
                }

                localStorage.setItem("admin_token", data.token);
                toastr.success("Admin login successful!");

                setTimeout(() => {
                    window.location.hash = "#admin-dashboard";
                }, 1500);
            },
            error: function (xhr) {
                let errorMsg = "Admin login failed.";
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
                    window.location.hash = "#account";
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
            window.location.hash = "#account";
        }, 1000);
    },

    adminLogout: function () {
        localStorage.removeItem("admin_token");
        toastr.info("Admin logged out.");
        setTimeout(() => {
            window.location.hash = "#admin-login";
        }, 1000);
    },

    loadUserProfile: function () {
        const token = localStorage.getItem("user_token");
        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}users/me`,
            type: "GET",
            headers: {
                "Authentication": token
            },
            dataType: "json",
            success: function (result) {
                console.log(result); 
                const user = result;
                $("#dash_first_name").val(user.first_name);
                $("#dash_last_name").val(user.last_name);
                $("#dash_email").val(user.email);
                $("#dash_birth_date").val(user.birth_date);
                $("#dash_address").val(user.address);
                $("#dash_phone").val(user.phone);
            },
            error: function (xhr) {
                let errorMsg = "Failed to load profile.";
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
    
    updateUserProfile: function (entity) {
        const token = localStorage.getItem("user_token");
        toastr.info("Updating profile...");
    
        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}users/me`,
            type: "PUT",
            headers: {
                "Authentication": token
            },
            data: JSON.stringify(entity),
            contentType: "application/json",
            dataType: "json",
            success: function () {
                toastr.success("Profile updated successfully!");
            },
            error: function (xhr) {
                let errorMsg = "Failed to update profile.";
                try {
                    const parsed = JSON.parse(xhr.responseText);
                    errorMsg = parsed.message || errorMsg;
                } catch (e) {
                    errorMsg = xhr.responseText;
                }
                toastr.error(errorMsg);
            }
        });
    }
    
};
