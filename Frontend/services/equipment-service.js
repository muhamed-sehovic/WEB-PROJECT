var EquipmentService = {
    getAll: function(callback) {
        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}equipment`,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (typeof callback === "function") {
                    callback(result);
                }
            },
            error: function(xhr) {
                let errorMsg = "Failed to fetch equipment.";
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

    getById: function(id, callback) {
        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}equipment/${id}`,
            type: "GET",
            dataType: "json",
            success: function(result) {
                if (typeof callback === "function") {
                    callback(result);
                }
            },
            error: function(xhr) {
                let errorMsg = "Failed to fetch equipment details.";
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

    add: function(data, callback) {
        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}equipment`,
            type: "POST",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(result) {
                toastr.success("Equipment added successfully.");
                if (typeof callback === "function") {
                    callback(result);
                }
            },
            error: function(xhr) {
                let errorMsg = "Failed to add equipment.";
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

    update: function(id, data, callback) {
        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}equipment/${id}`,
            type: "PUT",
            contentType: "application/json",
            data: JSON.stringify(data),
            success: function(result) {
                toastr.success("Equipment updated successfully.");
                if (typeof callback === "function") {
                    callback(result);
                }
            },
            error: function(xhr) {
                let errorMsg = "Failed to update equipment.";
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

    delete: function(id, callback) {
        $.ajax({
            url: `${Constants.PROJECT_BASE_URL}equipment/${id}`,
            type: "DELETE",
            success: function(result) {
                toastr.success("Equipment deleted successfully.");
                if (typeof callback === "function") {
                    callback(result);
                }
            },
            error: function(xhr) {
                let errorMsg = "Failed to delete equipment.";
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

    init: function() {
        this.getAll(function(data) {
            const tbody = document.querySelector("#equipmentTable tbody");
            tbody.innerHTML = '';  // Clear existing rows

            data.forEach(item => {
                const row = document.createElement("tr");
                row.innerHTML = `
                    <td>${item.category || '-'}</td>
                    <td>${item.model || '-'}</td>
                    <td>${item.description || '-'}</td>
                `;
                tbody.appendChild(row);
            });
        });
    }
};
