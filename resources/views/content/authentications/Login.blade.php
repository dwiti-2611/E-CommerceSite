@extends('layouts.blankLayout')

@section('title', 'Login')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
<style>
  .error {
    color: #dc3545;
  }
</style>
@endsection

@section('content')
<div class="container-xxl">
  <div class="authentication-wrapper authentication-basic container-p-y">
    <div class="authentication-inner">
      <!-- Register -->
      <div class="card">
        <div class="card-body">
          <!-- Logo -->
          <div class="app-brand justify-content-center">
            <a href="{{ url('/') }}" class="app-brand-link gap-2">
              <span class="app-brand-logo demo">@include('_partials.macros', ["width" => 25, "withbg" => 'var(--bs-primary)'])</span>
              <span class="app-brand-text demo text-body fw-bold">E-Commerce Site</span>
            </a>
          </div>
          <!-- /Logo -->
          <h4 class="mb-2">Welcome to E-Commerce Site! 👋</h4>
          <p class="mb-4">Please sign-in to your account and start the adventure</p>
          @if ($errors->any())
            <div class="alert alert-danger" id="error-alert">
              <ul>
                @foreach ($errors->all() as $error)
                  <li>{{ $error }}</li>
                @endforeach
              </ul>
            </div>
          @endif
          @if ($message = Session::get('success'))
          <div class="alert alert-success" id="success-alert">
            <p>{{ $message }}</p>
          </div>
          @endif
          <form id="formAuthentication" class="mb-3" method="POST" action="{{ route('Login.post') }}">
            @csrf
            <div class="mb-3">
              <label for="email" class="form-label">Email</label>
              <input type="email" class="form-control" id="email" name="email" value="{{ old('email') }}" placeholder="Enter your email" autofocus>
            </div>
            <div class="mb-3">
              <label class="form-label" for="password">Password</label>
              <input type="password" id="password" class="form-control" name="password" placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;" ><br>
              <a href="{{ url('auth/forgot-password-basic') }}">
                  <small>Forgot Password?</small>
              </a>
            <div class="mb-3">
              <button class="btn btn-primary d-grid w-100" type="submit" name='submit'>Sign in</button>
            </div>
          </form>
          <p class="text-center">
            <span>New on our platform?</span>
            <a href="{{ url('auth/register-basic') }}">
              <span>Create an account</span>
            </a>
          </p>
        </div>
      </div>
    </div>
    <!-- /Register -->
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
    jQuery('#formAuthentication').validate({
      rules: {
        email: {
          required: true,
          email: true
        },
        password: {
          required: true
        }
      },
      messages: {
        email: {
          required: "Please enter your email address",
          email: "Please enter a valid email address"
        },
        password: {
          required: "Please enter your password"
        }
      },
      submitHandler: function(form) {
        form.submit();
      }
    });

    // Hide success alert after 3 seconds
    setTimeout(function() {
      $('#success-alert').fadeOut('slow');
    }, 3000); // 3000 milliseconds = 3 seconds

    setTimeout(function() {
      $('#error-alert').fadeOut('slow');
    }, 3000); // 3000 milliseconds = 3 seconds

  });
</script>
@endsection
