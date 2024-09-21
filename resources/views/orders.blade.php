@extends('layouts.app')

@section('content')


<section class="section">
  <div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
      <div class="card py-5">
        <div class="card-body">
          <div class="table-responsive">
            <table class="table table-striped" id="usersTable">
            </table>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<!-- User Modal -->
<div class="modal fade" id="datailModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="userModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="detailModalTitle">Assignment Detail</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
         <div>
         <span class="badge" id="status"></span>           
           <div class="row mb-3">

            <div class="col-sm-3">
            <label for="" class="form-label">Words Count</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="wordCount"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
            </div>
            
            <div class="col-sm-3">
            <label for="" class="form-label">Price</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="price"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
            </div>
            <div class="col-sm-3">
            <label for="" class="form-label">Discount</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="discount"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
            </div>
           
           </div>
           <hr>
           <div class="mb-3">
            <label for="" class="form-label">Subject</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="subject"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
           </div>
           <div class="mb-3">
            <label for="" class="form-label">Service</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="service"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
           </div>
           <div class="row mb-3">
           <div class="col-sm-6">
           <label for="" class="form-label">Education Level</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="educationLevel"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
           </div>
           <div class="col-sm-6">
           <label for="" class="form-label">Referencing Style</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="referencingStyle"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
           </div>
           </div>
           <div class="row mb-3">
           <div class="col-sm-6">
           <label for="" class="form-label">User Name</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="userName"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
           </div>
           <div class="col-sm-6">
           <label for="" class="form-label">Contact #</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="contact"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
           </div>
           </div>
           
           <div class="mb-3">
           <label for="" class="form-label">University</label>
            <input
              type="text"
              class="form-control"
              name=""
              id="university"
              aria-describedby="helpId"
              disabled
              placeholder=""
            />
           </div>
         
         </div>
      </div>
    </div>
  </div>
</div>

<script>
$(document).ready(function() {
  var table = $('#usersTable').DataTable({
    'responsive': true,
    "processing": true,
    "serverSide": true,
    "ajax": {
      "url": "/orderList",
      "type": "GET",
      "dataSrc": function(json) {
        console.log(json);
        return json.data.assignments;
      }
    },
    "columns": [
      { 'title': 'Subject', "data": "subject" },
      { 'title': 'Status', "data": null,
        render:function(data,type, row){
            return `<span class="badge ps-2 pe-2" style="background-color:${row?.status_color}; color:#FFF;">${row?.status}</span>`;
        }
       },
      { 'title': 'Contact #', "data":null, 
        render:function(data,type, row){
            //row?.country_flag+
            return `${row?.country_code+row?.contact} `;
        }
       },
      { 'title': 'Price', "data":"price"},
      { 'title': 'Discount', "data":null,
        "render": function(data, type, row) {
          return `${row?.discount>0?row?.discount:'N/A'}`;
        }
      },
      { 'title': 'Actions',
        "data": null,
        "render": function(data, type, row) {
          return `
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-sm btn-info" onclick="viewAssignment(${row?.id})"><i class="bi bi-eye"></i></button>
              <button type="button" class="btn btn-sm btn-warning" onclick="editUser(${row?.id})"><i class="bi bi-pencil text-white"></i></button>
              <button type="button" class="btn btn-sm btn-danger btn-delete" onclick="deleteUser(${row?.id})"><i class="bi bi-trash"></i></button>
            </div>`;
        }
      }
    ],
    "pageLength": 10,
    "lengthMenu": [5, 10, 25, 50],
    "pagingType": "simple_numbers"
  });

  // Handle the form submission for creating and updating a user
  $('#userForm').on('submit', function(event) {
    event.preventDefault();
    var action = $('#userModal').data('action');
    var userId = $('#userId').val();
    var url = action === 'create' ? "/user-create" : `/api/users/${userId}`;
    var method = action === 'create' ? "POST" : "PUT";

    $.ajax({
      url: url,
      type: method,
      data: $(this).serialize(),
      success: function(response) {
        table.ajax.reload();
        $('#userModal').modal('hide');
        Swal.fire({
          position: "center",
          icon: "success",
          title: action === 'create' ? "User created successfully" : "User updated successfully",
          showConfirmButton: false,
          timer: 1500
        });
      },
      error: function(xhr) {
        var errors = xhr.responseJSON.errors;
        var errorHtml = '<ul>';
        for (var key in errors) {
          errors[key].forEach(function(error) {
            errorHtml += '<li>' + error + '</li>';
          });
        }
        errorHtml += '</ul>';
        $('#userFormErrors').html(errorHtml).removeClass('d-none');
      }
    });
  });

  // Function to open the modal for viewing a user
  window.viewUser = function(id) {
    $.ajax({
      url: `/users/${id}`,
      type: 'GET',
      success: function(user) {
        $('#userId').val(user.id);
        $('#userName').val(user.name).prop('readonly', true);
        $('#userEmail').val(user.email).prop('readonly', true);
        $('#userPassword').val('').prop('disabled', true);
        $('#userModalTitle').text('View User');
        $('#userModalSubmit').hide();
        $('#userFormErrors').addClass('d-none');
        $('#userModal').modal('show');
      },
      error: function(xhr) {
        console.error(xhr.responseText);
        alert('An error occurred while fetching user data');
      }
    });
  };


  // Function to delete a user
  window.deleteUser = function(id) {
    var table = $('#usersTable').DataTable();
    var currentPage = table.page();

    $.ajax({
      url: `/users/${id}`,
      type: 'DELETE',
      headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
      },
      success: function(response) {
        table.row($(`.btn-delete[onclick="deleteUser(${id})"]`).parents('tr')).remove().draw(false);
        table.page(currentPage).draw(false);
        Swal.fire({
          position: "center",
          icon: "success",
          title: "User deleted successfully",
          showConfirmButton: false,
          timer: 1500
        });
      },
      error: function(xhr) {
        alert('Error deleting user');
        console.log(xhr.responseText);
      }
    });
  };

  // Handle the modal toggle to set form action
  $('#userModal').on('show.bs.modal', function (event) {
    var button = $(event.relatedTarget); // Button that triggered the modal
    var action = button.data('action'); // Extract info from data-* attributes
    $('#userModal').data('action', action);
  });
});

function viewAssignment(id){
  $.ajax({
      url: `/assignment/${id}`,
      type: 'GET',
      success: function(res) {
        console.log(res);
        let data=res.data;
        $('#datailModal').modal('show');
        $('#status').text(data?.status);
        $('#subject').val(data?.subject);
        $('#service').val(data?.service);
        $('#educationLevel').val(data?.educationLevel);
        $('#referencingStyle').val(data?.referencingStyle);
        $('#userName').val(data?.user_name);
        $('#contact').val(data?.country_code+data?.contact);
        $('#university').val(data?.university);
        $('#wordCount').val(data?.pages*250);
        $('#price').val(data?.price);
        $('#discount').val(data?.discount);
        $('#discount').prop('disabled',data?.discount>0?true:false);
        $('#status').css({'background-color':'green'});
        // $('#userId').val(user.id);
        // $('#userName').val(user.name).prop('readonly', true);
        // $('#userEmail').val(user.email).prop('readonly', true);
        // $('#userPassword').val('').prop('disabled', true);
        // $('#userModalTitle').text('View User');
        // $('#userModalSubmit').hide();
        // $('#userFormErrors').addClass('d-none');
        // $('#userModal').modal('show');
      },
      error: function(xhr) {
        console.error(xhr.responseText);
        alert('An error occurred while fetching user data');
      }
    });
}
</script>

@endsection