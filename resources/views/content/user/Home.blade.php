@extends('layouts/contentNavbarLayout')

@section('title', 'Dashboard - Analytics')

@section('page-style')
<!-- Page -->
<link rel="stylesheet" href="{{ asset('assets/vendor/css/pages/page-auth.css') }}">
<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.0/css/bootstrap.min.css" />
@endsection

@section('content')
<div class="row">
  <div class="col-lg-8 mb-4 order-0">
    <div class="card">
      <div class="d-flex align-items-end row">
        <div class="card-body">
          <!-- Welcome message and success message -->
          <div class="col-12 d-flex justify-content-between">
            <h5 class="card-title text-primary">WELCOME {{ $user->name }}! 🎉</h5>
            @if ($message = Session::get('success'))
              <div class="alert alert-success" id="success-alert" style="margin-bottom: 0;">
                <p>{{ $message }}</p>
              </div>
            @endif
          </div>
          <!-- "Edit Profile" button -->
          <div class="col-12 d-flex justify-content-end mb-2">
            <a href="{{ route('users.edit', auth()->user()->id) }}" class="btn btn-primary">Edit Profile</a>
          </div>
          <!-- User info and image -->
          <div class="row">
            <div class="col-sm-7">
              <div class="form-group">
                <label for="name">NAME : </label> {{ $user->name }}
              </div>
              <div class="form-group">
                <label for="email">EMAIL ADDRESS : </label> {{ $user->email }}
              </div>
            </div>
          </div>
        </div>
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
    // Hide success alert after 3 seconds
    setTimeout(function() {
      $('#success-alert').fadeOut('slow');
    }, 3000); // 3000 milliseconds = 3 seconds
  });
</script>
@endsection
