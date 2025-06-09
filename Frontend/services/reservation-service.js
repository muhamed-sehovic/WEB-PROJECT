var ReservationService = {
    init: function () {
        $("#reservationForm").on("submit", function (e) {
            e.preventDefault();

            const token = localStorage.getItem("user_token");

            if (!token) {
                return toastr.error("You must be logged in to make a reservation.");
            }

            const entity = {
                first_name: $("#reservationName").val(),
                last_name: $("#reservationSurname").val(),
                email: $("#reservationEmail").val(),
                phone: $("#reservationPhone").val(),
                category: $("#reservationCategory").val(),
                date: $("#reservationDate").val(),
                time: $("#reservationTime").val(),
                include_engineer: $("#includeEngineer").is(":checked")
            };

            ReservationService.create(entity, token);
        });
    },

    create: function (entity, token) {
        toastr.info("Submitting reservation...");

        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}reservations`,
            type: "POST",
            headers: {
                "Authentication": token,
                "Content-Type": "application/json"
            },
            data: JSON.stringify(entity),
            dataType: "json",
            success: function () {
                toastr.success("Reservation successfully submitted!");
                $("#reservationForm")[0].reset();
            },
            error: function (xhr) {
                let errorMsg = "Failed to submit reservation.";
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
