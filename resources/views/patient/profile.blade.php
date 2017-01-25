@extends('layouts.layout')
@section('title', 'Profile | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	<div class="row">
		@include('layouts.sidebar')
		<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
          <div class="col-xs-7 col-sm-7 col-md-9">
            <div class="panel panel-info">
              <div class="panel-heading">Basic Information</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Age</td><td>{{$age}}</td></tr>
                  <tr><td>Sex</td><td>{{$sex}}</td></tr>
                  <tr><td>Course</td><td>{{$degree_program}}</td></tr>
                  <tr><td>Year Level</td><td>{{$year_level}}</td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="col-xs-5 col-sm-5 col-md-3">
              <img src="<?php echo asset('images/{{$picture}}')?>"  alt="Profile picture" height="200px" width="200px">
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Personal Data</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Date of Birth</td><td>{{$birthday}}</td></tr>
                  <tr><td>Religion</td><td>{{$religion}}</td></tr>
                  <tr><td>Nationality</td><td>{{$nationality}}</td></tr>
                  <tr><td>Father</td><td>{{$father}}</td></tr>
                  <tr><td>Mother</td><td>{{$mother}}</td></tr>
                  <tr><td>Home Address</td><td>{{$street}}, {{$town}}, {{$province}}</td></tr>
                  <tr><td>Residence Telephone Number</td><td>{{$residence_telephone_number}}</td></tr>
                  <tr><td>Residence Contact Number</td><td>{{$residence_contact_number}}</td></tr>
                  <tr><td>Personal Contact Number</td><td>{{$personal_contact_number}}</td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-6">
            <div class="panel panel-info">
              <div class="panel-heading">Guardian/Person to be Contacted in Case of Emergency</div>
              <div class="panel-body">
              <table class="table" style="margin-bottom: 0px;">
                <tbody>
                  <tr><td>Name</td><td>{{$guardian_first_name}} {{$guardian_middle_name}} {{$guardian_last_name}}</td></tr>
                  <tr><td>Address</td><td>{{$guardian_street}}, {{$guardian_town}}, {{$guardian_province}}</td></tr>
                  <tr><td>Relationship</td><td>{{$relationship}}</td></tr>
                  <tr><td>Residence Telephone Number</td><td>{{$guardian_tel_number}}</td></tr>
                  <tr><td>Cellphone Number</td><td>{{$guardian_cellphone}}</td></tr>
                </tbody>
              </table>
              </div>
            </div>
          </div>
          <div class="col-xs-12 col-sm-12 col-md-12">
          <div class="clearfix">
          <div class="pull-left">
          <a href="{{ url('account/profile/edit') }}" class="btn btn-primary" role="button">Edit Profile</a>
          </div>
          </div>
          </div>
          </div>
	</div>
</div>

@endsection