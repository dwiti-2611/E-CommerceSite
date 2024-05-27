@extends('layouts/blankLayout')

@section('title', 'Register')

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
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register Card -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{url('/')}}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros',["width"=>25,"withbg"=>'var(--bs-primary)'])</span>
              <span class="app-brand-text demo text-body fw-bold">E-Commerce Site</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Adventure starts here 🚀</h4>
          <p class="mb-4">Make your app management easy and fun!</p>
          <form id="formAuthentication" class="mb-3" action="{{ route('auth-register-basic.post') }}" method="POST">
              @csrf
              <div class="mb-3">
                  <label for="username" class="form-label">Username</label>
                  <input type="text" class="form-control" id="name" name="name" placeholder="Enter your username" autofocus>
              </div>
              <div class="mb-3">
                  <label for="email" class="form-label">Email</label>
                  <input type="text" class="form-control" id="email" name="email" placeholder="Enter your email">
              </div>
              <div class="mb-3">
                <label class="form-label" for="password">Password</label>
                <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password" />
                <div class="note-box mt-2">
                  <p class="note-text">Your password must be at least 8 characters long and include at least one uppercase letter, one lowercase letter, one digit, and one special character.</p>
                </div>
              </div>
              <div class="mb-3">
                  <label class="form-label" for="password_confirmation">Confirm Password</label>
                  <input type="password" id="password_confirmation" class="form-control" name="password_confirmation" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" aria-describedby="password_confirmation" />
              </div>
              <button id="submitBtn" class="btn btn-primary d-grid w-100" type="submit">
                  Sign up
              </button>
          </form>

          <p class="text-center">
              <span>Already have an account?</span>
              <a href="{{ url('/') }}">
                  <span>Sign in instead</span>
              </a>
          </p>

        </div>
      </div>
      <!-- Register Card -->
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

    // Custom method to validate email uniqueness
    jQuery.validator.addMethod("uniqueEmail", function(value, element) {
      return this.optional(element) || !existingEmails.includes(value);
    }, "This email is already registered");

    jQuery.validator.addMethod("passwordFormat", function(value, element) {
    return this.optional(element) || /^(?=.*[a-z])(?=.*[A-Z])(?=.*\d)(?=.*[@$!%*?&])[A-Za-z\d@$!%*?&]{8,}$/.test(value);
    }, "Your password must 8 characters long and must be in the format that include at least one uppercase letter, one lowercase letter, one digit, and one special character");

    $('#formAuthentication').validate({
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
          equalTo: "#password"
        }
      },
      messages: {
        name: {
          required: "Please enter your username",
          lettersOnly: "Please enter letters only",
          minlength: "The name should be at least 3 letters"
        },
        email: {
          required: "Please enter your email address",
          email: "Please enter a valid email address",
          uniqueEmail: "This email is already registered, Sign In instead"
        },
        password: {
          required: "Please enter your password",
          minlength: "Your password must be at least 8 characters long",
          passwordFormat: "Your password must include at least one uppercase letter, one lowercase letter, one digit, and one special character",
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
      onfocusout: function(element) {
        $(element).valid();
      },
      invalidHandler: function(event, validator) {
        // Display alert on invalid submission
        alert('Please correct the errors in the form!');
      },
      submitHandler: function(form) {
        // Optionally handle successful validation before form submission
        form.submit();
      }
    });

    $('#submitBtn').click(function() {
      $('#formAuthentication').submit();
    });
  });
</script>
@endsection
