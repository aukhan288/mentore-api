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
<div class="modal fade" id="userModal" tabindex="-1" data-bs-backdrop="static" data-bs-keyboard="false" role="dialog" aria-labelledby="userModalTitle" aria-hidden="true">
  <div class="modal-dialog modal-dialog-scrollable modal-dialog-centered modal-md" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="userModalTitle">User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="userForm" action="">
          <div id="userFormErrors" class="alert alert-danger d-none"></div>
          <input type="hidden" id="userId" name="id" />
          <div class="mb-3">
            <label for="userName" class="form-label">Name</label>
            <input type="text" class="form-control" name="name" id="userName" placeholder="Name" required />
          </div>
          <div class="mb-3">
            <label for="userEmail" class="form-label">Email</label>
            <input type="email" class="form-control" name="email" id="userEmail" placeholder="Email" required />
          </div>
          <div class="mb-3">
            <label for="userPassword" class="form-label">Password</label>
            <input type="password" class="form-control" name="password" id="userPassword" placeholder="Password (leave blank to keep current)" />
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
            <button type="submit" class="btn btn-primary" id="userModalSubmit">Save</button>
          </div>
        </form>
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
      "url": "/userList/",
      "type": "GET",
      "dataSrc": function(json) {
        console.log(json);
        return json.data;
      }
    },
    "columns": [
      { 'title': 'Name', "data": "name" },
      { 'title': 'Email', "data": "email" },
      { 'title': 'Contact #', "data":null, 
        render:function(data,type, row){
            //row?.country_flag+
            return `${row?.country_code+row?.contact} `;
        }
       },
      { 'title': 'Actions',
        "data": null,
        "render": function(data, type, row) {
          return `
            <div class="btn-group" role="group" aria-label="Basic example">
              <button type="button" class="btn btn-sm btn-info" onclick="viewUser(${row?.id})"><i class="bi bi-eye"></i></button>
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

  // Function to open the modal for editing a user
  window.editUser = function(id) {
    $.ajax({
      url: `/users/${id}`,
      type: 'GET',
      success: function(user) {
        $('#userId').val(user.id);
        $('#userName').val(user.name).prop('readonly', false);
        $('#userEmail').val(user.email).prop('readonly', false);
        $('#userPassword').val('');
        $('#userModalTitle').text('Edit User');
        $('#userModalSubmit').text('Save Changes').show();
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
</script>

@endsection