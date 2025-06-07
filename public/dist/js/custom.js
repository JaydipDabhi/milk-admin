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

$(function () {
    $("#reservationdate").datetimepicker({
        format: "L",
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
    $("#exampleInputRole1").on("change", function () {
        $(this).valid();
    });

    $("#customerForm").validate({
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
            $(element).addClass("is-invalid");
        },
        unhighlight: function (element) {
            $(element).removeClass("is-invalid");
        },
    });

    // jQuery("#customer_id").on("input", function () {
    //     let customerId = jQuery(this).val();
    //     if (customerId.length > 0) {
    //         $.ajax({
    //             url: "/milk-delivery/get-customer-info",
    //             type: "GET",
    //             data: {
    //                 _token: "{{ csrf_token() }}",
    //                 customer_id: customerId,
    //             },
    //             success: function (response) {
    //                 jQuery("#customer_name")
    //                     .text(response.name)
    //                     .removeClass("text-danger")
    //                     .addClass("text-success");
    //             },
    //             error: function (xhr) {
    //                 if (xhr.status === 404) {
    //                     jQuery("#customer_name")
    //                         .text("Customer not found")
    //                         .removeClass("text-success")
    //                         .addClass("text-danger");
    //                 } else {
    //                     jQuery("#customer_name")
    //                         .text("Error fetching customer info")
    //                         .removeClass("text-success")
    //                         .addClass("text-danger");
    //                 }
    //             },
    //         });
    //     } else {
    //         jQuery("#customer_name").text("");
    //     }
    // });
});

document.addEventListener("DOMContentLoaded", function () {
    // Auto-select time
    const morning = document.getElementById("morning");
    const evening = document.getElementById("evening");

    // Auto-select time based on current hour
    const hour = new Date().getHours();
    if (hour < 12) {
        morning.checked = true;
        evening.disabled = true;
    } else {
        evening.checked = true;
        morning.disabled = true;
    }

    // Disable the other option when one is selected
    morning.addEventListener("change", function () {
        if (morning.checked) {
            evening.disabled = true;
        } else {
            evening.disabled = false;
        }
    });

    evening.addEventListener("change", function () {
        if (evening.checked) {
            morning.disabled = true;
        } else {
            morning.disabled = false;
        }
    });
});
