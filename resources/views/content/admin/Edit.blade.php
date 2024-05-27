@extends('layouts/contentNavbarLayout')

@section('title', 'Edit Admin')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<style>
  .position-absolute-upper-right {
    position: absolute;
    top: 20px;
    right: 20px;
  }
  .card-body {
    position: relative; /* Ensure the card body is the positioning context */
  }
</style>
@endsection

@section('content')
<div class="row">
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-primary">EDIT ADMIN PROFILE</h5>
        <a href="{{ route('admin.profile') }}" class="btn btn-primary position-absolute-upper-right">Profile Page</a>
        <form id='admin-edit' action="{{ route('admin.update', $admin->id) }}" method="POST">
          @csrf
          @method('PUT')
          <div class="form-group">
            <label for="name">Name</label>
            <input type="text" class="form-control" id="name" name="name" value="{{ $admin->name }}" required>
          </div>
          <div class="form-group">
            <label for="email">Email</label>
            <input type="email" class="form-control" id="email" name="email" value="{{ $admin->email }}" required>
          </div>
          <!-- Add other fields as needed -->
          <button type="submit" class="btn btn-primary">Update Profile</button>
        </form>
      </div>
    </div>
  </div>
</div>
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

    // Custom method to validate email uniqueness
    jQuery.validator.addMethod("uniqueEmail", function(value, element) {
      return this.optional(element) || !existingEmails.includes(value);
    }, "This email is already registered");

    // Hide success alert after 3 seconds
    setTimeout(function() {
      $('#success-alert').fadeOut('slow');
    }, 3000);

    // jQuery validation for the register user form
    jQuery('#admin-edit').validate({
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
        }
      },
      errorClass: 'text-danger',
      errorElement: 'span',
      errorPlacement: function(error, element) {
        error.insertAfter(element);
      },
      // Adding onkeyup, onfocusout and onclick handlers for real-time validation
      onkeyup: function(element) { $(element).valid(); },
      onfocusout: function(element) { $(element).valid(); },
      onclick: function(element) { $(element).valid(); },
      submitHandler: function(form) {
        form.submit();
      }
    });
  });
</script>
@endsection
@endsection
