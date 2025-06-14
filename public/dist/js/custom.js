$(function () {
    $("#example1")
        .DataTable({
            responsive: true,
            lengthChange: false,
            autoWidth: false,
            buttons: ["copy", "csv", "excel", "pdf", "print", "colvis"],
        })
        .buttons()
        .container()
        .appendTo("#example1_wrapper .col-md-6:eq(0)");
    $("#example2").DataTable({
        paging: true,
        lengthChange: false,
        searching: false,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
    });
    $(".select2").select2();
});

function confirmUserDelete(userId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This user will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + userId).submit();
        }
    });
}
function confirmCustomerDelete(customerId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This customer will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + customerId).submit();
        }
    });
}
function confirmRateDelete(rateId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This Rate will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + rateId).submit();
        }
    });
}
function confirmMilkDeliveryDelete(deliveryId) {
    Swal.fire({
        title: "Are you sure?",
        text: "This Milk Delivery will be permanently deleted!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#d33",
        cancelButtonColor: "#6c757d",
        confirmButtonText: "Yes, delete it!",
    }).then((result) => {
        if (result.isConfirmed) {
            document.getElementById("delete-form-" + deliveryId).submit();
        }
    });
}

// flatpickr("#delivery_date", {
//     dateFormat: "Y-m-d",
//     defaultDate: new Date(),
//     maxDate: "today",
// });

// $(function () {
//     $("#reservationdate").datetimepicker({
//         format: "DD-MM-YYYY",
//         maxDate: moment(),
//     });
// });

$(function () {
    $("#reservationdate").datetimepicker({
        format: "DD-MM-YYYY",
        // minDate: moment().startOf("day"),
        maxDate: moment().endOf("day"),
    });
});

jQuery(document).ready(function () {
    jQuery("#userForm").validate({
        rules: {
            name: {
                required: true,
                minlength: 2,
            },
            email: {
                required: true,
                email: true,
            },
            mobile: {
                required: true,
                digits: true,
                minlength: 10,
                maxlength: 10,
            },
            role: {
                required: true,
            },
            password: {
                required: true,
                minlength: 6,
            },
            password_confirmation: {
                required: true,
                equalTo: "#exampleInputPassword1",
            },
        },
        messages: {
            name: {
                required: "Please enter a name",
                minlength: "Name must be at least 2 characters",
            },
            email: {
                required: "Please enter an email",
                email: "Please enter a valid email address",
            },
            mobile: {
                required: "Please enter a mobile number",
                digits: "Only numeric values allowed",
                minlength: "Mobile number must be at least 10 digits",
                maxlength: "Mobile number can't exceed 10 digits",
            },
            role: {
                required: "Please select a role",
            },
            password: {
                required: "Please enter a password",
                minlength: "Password must be at least 6 characters",
            },
            password_confirmation: {
                required: "Please confirm your password",
                equalTo: "Passwords do not match",
            },
        },
        errorElement: "div",
        errorPlacement: function (error, element) {
            error.addClass("text-danger");
            if (element.hasClass("select2-hidden-accessible")) {
                error.insertAfter(element.next(".select2"));
            } else {
                error.insertAfter(element);
            }
        },
        highlight: function (element) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element)
                    .next(".select2")
                    .find(".select2-selection")
                    .addClass("is-invalid");
            } else {
                $(element).addClass("is-invalid");
            }
        },
        unhighlight: function (element) {
            if ($(element).hasClass("select2-hidden-accessible")) {
                $(element)
                    .next(".select2")
                    .find(".select2-selection")
                    .removeClass("is-invalid");
            } else {
                $(element).removeClass("is-invalid");
            }
        },
    });

    // Re-validate role field on change (important for Select2)
    jQuery("#exampleInputRole1").on("change", function () {
        jQuery(this).valid();
    });

    jQuery("#customerForm").validate({
        rules: {
            customer_name: {
                required: true,
                minlength: 2,
            },
        },
        messages: {
            customer_name: {
                required: "Please enter customer name",
                minlength: "Name must be at least 2 characters",
            },
        },
        errorElement: "span",
        errorPlacement: function (error, element) {
            error.addClass("text-danger");
            element.closest(".form-group").append(error);
        },
        highlight: function (element) {
            jQuery(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            jQuery(element).removeClass("is-invalid");
        },
    });

    jQuery("#milkAddForm").validate({
        rules: {
            customer_id: {
                required: true,
                number: true,
                min: 1,
            },
            weight: {
                required: true,
                number: true,
                min: 0.01,
            },
            delivery_date: {
                required: true,
                date: true,
            },
            time: {
                required: true,
            },
        },
        messages: {
            customer_id: {
                required: "Customer number is required.",
                number: "Please enter a valid number.",
                min: "Customer ID must be greater than 0.",
            },
            weight: {
                required: "Please enter weight in liters.",
                number: "Enter a valid number.",
                min: "Weight must be at least 0.01 liters.",
            },
            delivery_date: {
                required: "Please select a delivery date.",
                date: "Enter a valid date.",
            },
            time: {
                required: "Please select Morning or Evening.",
            },
        },
        errorElement: "span",
        errorClass: "text-danger",
        errorPlacement: function (error, element) {
            if (element.attr("name") === "time") {
                error.insertAfter(
                    element.closest(".form-group").find(".form-check").last()
                );
            } else {
                const fieldId = element.attr("id");
                error.attr("id", fieldId + "-error");
                element.attr("aria-describedby", fieldId + "-error");
                error.insertAfter(
                    element.closest(".form-group").find(".input-group").length
                        ? element.closest(".form-group").find(".input-group")
                        : element
                );
            }
        },
        highlight: function (element) {
            jQuery(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            jQuery(element)
                .removeClass("is-invalid")
                .removeAttr("aria-describedby");
            const errorId = jQuery(element).attr("id") + "-error";
            jQuery("#" + errorId).remove();
        },
    });
});

// document.addEventListener("DOMContentLoaded", function () {
//     // Auto-select time
//     const morning = document.getElementById("morning");
//     const evening = document.getElementById("evening");

//     // Auto-select time based on current hour
//     const hour = new Date().getHours();
//     if (hour < 12) {
//         morning.checked = true;
//         evening.disabled = true;
//     } else {
//         evening.checked = true;
//         morning.disabled = true;
//     }

//     // Disable the other option when one is selected
//     morning.addEventListener("change", function () {
//         if (morning.checked) {
//             evening.disabled = true;
//         } else {
//             evening.disabled = false;
//         }
//     });

//     evening.addEventListener("change", function () {
//         if (evening.checked) {
//             morning.disabled = true;
//         } else {
//             morning.disabled = false;
//         }
//     });
// });
