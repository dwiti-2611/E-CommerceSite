@extends('layouts/contentNavbarLayout')

@section('title', 'Change Password')

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
<div class="row">
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="card-body">
        <h5 class="card-title text-primary">Change Password</h5>
        @if ($message = Session::get('success'))
          <div class="alert alert-success" id="success-alert">
            <p>{{ $message }}</p>
          </div>
        @endif
        <a href="{{ route('admin.profile') }}" class="btn btn-primary position-absolute-upper-right">Profile Page</a>
        <form id="change-password-form" action="{{ route('user.ChangePassword.post') }}" method="POST">
          @csrf
          <div class="form-group">
            <label for="current_password">Current Password</label>
            <input type="password" class="form-control" id="current_password" name="current_password" required>
          </div>
          <div class="form-group">
            <label for="new_password">New Password</label>
            <input type="password" class="form-control" id="new_password" name="new_password" required>
          </div>
          <div class="note-box mt-2">
            <p class="note-text">Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.</p>
          </div>
          <div class="form-group">
            <label for="new_password_confirmation">Confirm New Password</label>
            <input type="password" class="form-control" id="new_password_confirmation" name="new_password_confirmation" required>
          </div>
          <button type="submit" class="btn btn-primary">Change Password</button>
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
<script>
    jQuery.validator.addMethod("validCurrentPassword", function(value, element) {
    var isValid = false;

    // AJAX call to validate the current password
    $.ajax({
        type: "POST",
        url: "{{ route('admin.verifyPassword') }}",
        data: {
            _token: "{{ csrf_token() }}",
            current_password: value
        },
        async: false, // make the call synchronous
        success: function(response) {
            isValid = response.valid;
        }
    });

    return isValid;
}, "The current password does match the existing password.");

jQuery.validator.addMethod("passwordFormat", function(value, element) {
  return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
}, "Your password must 8 characters long and must be in the format that include at least one uppercase letter, one lowercase letter, one digit, and one special character");

jQuery('#change-password-form').validate({
    rules: {
        current_password: {
            required: true,
            validCurrentPassword: true // Use the custom validation method
        },
        new_password: {
          required: true,
          minlength: 8,
          passwordFormat: true
        },
        new_password_confirmation: {
            required: true,
            equalTo: "#new_password"
        }
    },
    messages: {
        current_password: {
            required: "Please enter your current password"
        },
        new_password: {
          required: "Please provide a password",
          passwordFormat: "Your password must include at least one uppercase letter, one lowercase letter, one digit, and one special character",
          minlength: "Your password must be at least 8 characters long"
        },
        new_password_confirmation: {
            required: "Please confirm your new password",
            equalTo: "Passwords do not match"
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

jQuery(document).ready(function() {
    // Hide success alert after 3 seconds
    setTimeout(function() {
        $('#success-alert').fadeOut('slow');
    }, 3000); // 3000 milliseconds = 3 seconds
});
</script>
@endsection
