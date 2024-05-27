@extends('layouts/contentNavbarLayout')

@section('title', 'Home Page')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<style>
  .note-box {
    border: 1px solid red;
    background-color: #fff0f0;
    padding: 10px;
    border-radius: 5px;
  }
  .note-text {
    margin: 0;
    color: red;
    font-weight: 300;
    font-size: 0.875rem;
  }
</style>
@endsection

@section('content')
@if ($message = Session::get('success'))
  <div class="alert alert-success" id="success-alert">
    <p>{{ $message }}</p>
  </div>
@endif
<div class="card">
  <h5 class="card-header">Users
    <button type="button" class="btn btn-primary float-end" data-bs-toggle="modal" data-bs-target="#registerUserModal">Register User</button>
  </h5>
  <div class="table-responsive text-nowrap">
    <table class="table">
      <thead>
        <tr>
          <th>Sr. NO.</th>
          <th>USERNAME</th>
          <th>EMAIL ADDRESS</th>
          <th>ACTIONS</th>
        </tr>
      </thead>
      <tbody class="table-border-bottom-0">
        @foreach ($users as $user)
        <tr>
          <td>{{ ++$i }}</td>
          <td>{{ $user->name }}</td>
          <td>{{ $user->email }}</td>
          <td>
            <a href="{{ route('users.edit', $user->id) }}"><i class="bx bx-edit-alt me-1"></i> Edit</a>
            <a href="{{ route('users.destroy', $user->id) }}" onclick="event.preventDefault(); document.getElementById('delete-form-{{ $user->id }}').submit();"><i class="bx bx-trash me-1"></i> Delete</a>
            <form id="delete-form-{{ $user->id }}" action="{{ route('users.destroy', $user->id) }}" method="POST" style="display: none;">
              @csrf
              @method('DELETE')
            </form>
          </td>
        </tr>
        @endforeach
      </tbody>
    </table>
  </div>
</div>

<!-- Modal for Register User -->
<div class="modal fade" id="registerUserModal" tabindex="-1" aria-labelledby="registerUserModalLabel" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="registerUserModalLabel">Register New User</h5>
        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
      </div>
      <div class="modal-body">
        <form id="registerUserForm" method="POST" action="{{ route('users.store') }}">
          @csrf
          <div class="mb-3">
            <label for="name" class="form-label">Username</label>
            <input type="text" class="form-control" id="name" name="name" required>
          </div>
          <div class="mb-3">
            <label for="email" class="form-label">Email address</label>
            <input type="email" class="form-control" id="email" name="email" required>
          </div>
          <div class="mb-3">
            <label for="password" class="form-label">Password</label>
            <input type="password" class="form-control" id="password" name="password" required>
          </div>
          <div class="note-box mt-2">
            <p class="note-text">Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.</p>
          </div>
          <div class="mb-3">
            <label for="password_confirmation" class="form-label">Confirm Password</label>
            <input type="password" class="form-control" id="password_confirmation" name="password_confirmation" required>
          </div>
          <button type="submit" class="btn btn-primary">Register</button>
        </form>
      </div>
    </div>
  </div>
</div>

@endsection


@section('page-script')
<!-- jQuery -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.0/jquery.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-validate/1.19.1/jquery.validate.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.1/moment.min.js"></script>

<script>
  jQuery(document).ready(function() {

    // Preload emails from server-side
    var existingEmails = @json($emails);

    // Custom method to validate letters and spaces only
    jQuery.validator.addMethod("lettersOnly", function(value, element) {
      return this.optional(element) || /^[a-zA-Z\s]+$/.test(value);
    }, "Please enter letters only");

    jQuery.validator.addMethod("passwordFormat", function(value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
    }, "Your password must 8 characters long and must be in the format that include at least one uppercase letter, one lowercase letter, one digit, and one special character");

    // Custom method to validate email uniqueness
    jQuery.validator.addMethod("uniqueEmail", function(value, element) {
    return this.optional(element) || !existingEmails.includes(value);
    }, "This email is already registered");

    // Hide success alert after 3 seconds
    setTimeout(function() {
      $('#success-alert').fadeOut('slow');
    }, 3000);

    // jQuery validation for the register user form
    jQuery('#registerUserForm').validate({
      rules: {
        name: {
          required: true,
          lettersOnly: true,
          minlength: 3
        },
        email: {
          required: true,
          email: true,
          uniqueEmail: true
        },
        password: {
          required: true,
          minlength: 8,
          passwordFormat: true
        },
        password_confirmation: {
          required: true,
          equalTo: '#password'
        }
      },
      messages: {
        name: {
          required: "Please enter the username",
          lettersOnly: "Please enter letters only",
          minlength: "The name should be atleast 3 letters"
        },
        email: {
          required: "Please enter the email address",
          email: "Please enter a valid email address",
          uniqueEmail: "This email is already registered"
        },
        password: {
          required: "Please provide a password",
          passwordFormat: "Your password must include at least one uppercase letter, one lowercase letter, one digit, and one special character",
          minlength: "Your password must be at least 8 characters long"
        },
        password_confirmation: {
          required: "Please confirm your password",
          equalTo: "Password confirmation does not match"
        }
      },
      errorClass: 'text-danger',
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>
@endsection
