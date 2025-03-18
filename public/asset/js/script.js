const toggleSwitch = document.querySelector(
  '.theme-switch input[type="checkbox"]'
);

$(document).ready(function () {
  $("#departments").on("change", function () {
    let selected = $(this).val();
    let url = $(this).attr("data-url");
    let csrfToken = $('meta[name="csrf-token"]').attr("content");

    $.ajax({
      url: url,
      type: "POST",
      data: { department: selected },
      headers: { "X-CSRF-TOKEN": csrfToken },
      success: function (response) {
        if (response.status == true) {
          let data = response.data;
          $("#QueryMember").empty();
          data.forEach(function (item) {
            $("#QueryMember").append(
              '<option value="' + item.id + '">' + item.name + "</option>"
            );
          });
        } else {
          $("#QueryMember").empty();
        }
      },
      error: function (jqXHR, textStatus, errorThrown) {
        console.log(errorThrown);
      },
    });
  });

  $("#contact-form").on("submit", function (event) {
    event.preventDefault();
    let csrfToken = $('meta[name="csrf-token"]').attr("content");
    let form = $(this).serialize();
    let url = $(this).attr("url");
    $.ajax({
      url: url,
      type: "POST",
      headers: { "X-CSRF-TOKEN": csrfToken },
      data: form,
      beforeSend: function () {
        $("#loader").removeClass("d-none");
      },
      success: function (response) {
        $("#loader").addClass("d-none");
        $("#error").removeClass("d-none");
        console.log(response.QueryID);
        Swal.fire({
          title: "Query Submitted!",
          html: `Track your query by registering or logging into your account.<br>Save your Query ID <strong>${response.QueryID}</strong> to track the progress of your query.`,
          imageUrl:
            "https://safetycircleindia.com/wp-content/uploads/2024/06/Safety-circle-R-logo-changes.png",
          imageWidth: 200,
          imageHeight: 200,
          imageAlt: "Server Error",
          customClass: {
            image: "rounded-image",
            confirmButton: "custom-ok-button",
          },
          confirmButtonText: "OK",
        }).then((result) => {
          if (result.isConfirmed) {
            window.location.reload(true);
          }
        });

        const style = document.createElement("style");
        style.innerHTML = `
            .rounded-image {
                border-radius: 50%; 
            }
            .custom-ok-button {
                background-color: red; 
                color: white; 
            }
        `;
        document.head.appendChild(style);
      },

      error: function (jqXHR, textStatus, errorThrown) {
        $("#loader").addClass("d-none");
        console.log(errorThrown);
      },
    });
  });

  let url = $("#data-url").attr("data-url");
  console.log(url);

  // Initialize DataTable
  // $("#dataTable").DataTable({
  //   paging: true,
  //   lengthChange: true,
  //   searching: true,
  //   ordering: true,
  //   info: true,
  //   autoWidth: false,
  //   responsive: true,
  //   serverSide: true,   // Enable server-side processing
  //   processing: true,   // Show processing indicator
  //   "ajax": {
  //       "url": url,
  //       "type": "GET"
  //   },
  //   "columns": [
  //       { "data": "id" },
  //       { "data": "queryUser.name" },
  //       { "data": "queryUser.email" },
  //       // Add more columns as needed
  //   ],
  //   language: {
  //       lengthMenu: "Show _MENU_ records per page",
  //       zeroRecords: "No records found",
  //       info: "Showing _START_ to _END_ of _TOTAL_ records",
  //       infoEmpty: "No records found",
  //       infoFiltered: "(filtered from _MAX_ total records)",
  //       search: "Search:",
  //       paginate: {
  //           first: "First",
  //           last: "Last",
  //           next: "Next",
  //           previous: "Previous"
  //       }
  //   }
  // });
});
