@extends('layouts.layout')
@section('title', 'Dashboard | UP Visayas Health Services Unit')
@section('content')
<div class="container-fluid">
	@include('layouts.sidebar')
	<div class="col-sm-9 col-sm-offset-3 col-md-10 col-md-offset-2 main" id="patientDashboard">
		<h4 class="page-header">
		@if(!is_null(Auth::user()->staff->picture))
		<img src="{{asset('images/'.Auth::user()->staff->picture)}}" height="50" width="50" class="img-circle"/> 
		@else
		<img src="{{asset('images/blankprofpic.png')}}" height="50" width="50" class="img-circle"/> 
		@endif
		Welcome <i>{{ Auth::user()->staff->staff_first_name }} {{ Auth::user()->staff->staff_last_name }}</i>!</h4>
		<ul class="nav nav-tabs">
      <li><a data-toggle="tab" href="#pastappointment">Past</a></li>
      <li class="active"><a data-toggle="tab" href="#todayappointment">Today</a></li>
    </ul>
    <br>
		<div class="tab-content">
			<div class="tab-pane fade in active" id="todayappointment">
				<div class="row">
					<div class="col-md-6">
					<div class="tile-stats">
					<input type="hidden" id="cashiergraphtrigger" value="1"/>
					<div id="cashierdashboard" style="height: 500px"></div>
					</div></div>
					<div class="col-md-6" style="font-size: 10px">
						<div class="panel panel-default">
							<div class="panel-heading">Medical Billing</div>
						  <div class="panel-body">
						  	<table class="table table">
						  		<tbody>
							      <tr class="active">
							        <td>Total Patients Today</td>
							        <td>{{ $medical_patient_count }}</td>
							      </tr> 
							      <tr class="danger">
							        <td>Total Patients Unbilled</td>
							        <td>{{ $medical_unbilled_count }}</td>
							      </tr>  
							      <tr class="info">
							        <td>Total Patients Billed</td>
							        <td>{{ $medical_billed_count }}</td>
							      </tr> 
							      <tr class="success">
							        <td>Total Patients Paid</td>
							        <td>{{ $medical_paid_count }}</td>
							      </tr> 
							      {{-- <tr class="warning">
							        <td>Total Patients Unpaid</td>
							        <td>{{ $medical_unpaid_count }}</td>
							      </tr>  --}}
							    </tbody>  
						  	</table>
						  </div>
						</div>
						<div class="panel panel-default">
							<div class="panel-heading">Dental Billing</div>
						  <div class="panel-body">
						  	<table class="table table">
						  		<tbody>
							      <tr class="active">
							        <td>Total Patients Today</td>
							        <td>{{ $dental_patient_count }}</td>
							      </tr> 
							      <tr class="danger">
							        <td>Total Patients Unbilled</td>
							        <td>{{ $dental_unbilled_count }}</td>
							      </tr>  
							      <tr class="info">
							        <td>Total Patients Billed</td>
							        <td>{{ $dental_billed_count }}</td>
							      </tr> 
							      <tr class="success">
							        <td>Total Patients Paid</td>
							        <td>{{ $dental_paid_count }}</td>
							      </tr> 
							      {{-- <tr class="warning">
							        <td>Total Patients Unpaid</td>
							        <td>{{ $dental_unpaid_count }}</td>
							      </tr>  --}}
							    </tbody>  
						  	</table>
						  </div>
						</div>
						<form action="/cashier/billingtoday" method="POST">{{ csrf_field() }}<input type="submit" class="btn btn-primary btn-block" value="View Today's Patients"></form>
					</div>
				</div>
				
			</div>
			<div class="tab-pane" id="pastappointment">
				<div class="row">
					<div class="col-md-6">
						<div class="panel panel-success">
				      <div class="panel-heading">Medical Billing</div>
				      <div class="panel-body">
				      	<h5>Receivable Amount:</h5>
				      	<div class="well" style="height:50px;"><p id="receivable_medical">{{ $receivable_medical->amount }}</p></div>
				      	{{-- <input type="text" class="form-control" id="receivable_medical" value="" disabled> --}}
				      	<hr>
				      	@if(count($unpaid_bills_medical)>0)
				      	<table class="table table-striped" id="medical_billing_past">
									<thead>
										<tr>
											<th>Patient</th>
											<th>Consultation Date</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
									@foreach($unpaid_bills_medical as $unpaid_bill_medical)
										<tr id="add_medical_billing_tr_{{$unpaid_bill_medical->medical_appointment_id}}"><td>{{ $unpaid_bill_medical->patient_first_name }} {{ $unpaid_bill_medical->patient_last_name }}</td>
												<td>{{ date_format(date_create($unpaid_bill_medical->schedule_day), 'F j, Y')}}</td>
												<td><button class="btn btn-primary btn-xs addMedicalBilling" id="add_medical_billing_{{$unpaid_bill_medical->medical_appointment_id}}_{{$unpaid_bill_medical->amount}}">Pay Bill</button></td>
										</tr>
									@endforeach
									</tbody>
								</table>
								@endif
				      </div>
				    </div>
					</div>
					<div class="col-md-6">
						<div class="panel panel-success">
							<div class="panel-heading">Dental Billing</div>
				      <div class="panel-body">
				      	<h5>Receivable Amount:</h5>
				      	<div class="well" style="height:50px;"><p id="receivable_dental">{{ $receivable_dental->amount }}</p></div>
				      	{{-- <input type="text" class="form-control" id="receivable_dental" value="{{ $receivable_dental->amount }}" disabled> --}}
				      	<hr>
				      	@if(count($unpaid_bills_dental)>0)
				      	<table class="table table-striped" id="dental_billing_past">
									<thead>
										<tr>
											<th>Patient</th>
											<th>Consultation Date</th>
											<th></th>
										</tr>
									</thead>
									<tbody>
										@foreach($unpaid_bills_dental as $unpaid_bill_dental)
										<tr id="add_dental_billing_tr_{{$unpaid_bill_dental->appointment_id}}">
												<td>{{ $unpaid_bill_dental->patient_first_name }} {{ $unpaid_bill_dental->patient_last_name }}</td>
												<td>{{ date_format(date_create($unpaid_bill_dental->schedule_start), 'h:i A')}} - {{ date_format(date_create($unpaid_bill_dental->schedule_end), 'h:i A') }}</td>
												<td><button class="btn btn-primary btn-xs addDentalBilling" id="add_dental_billing_{{$unpaid_bill_dental->appointment_id}}_{{$unpaid_bill_dental->amount}}">Pay Bill</button></td>
										</tr>
										@endforeach
										
									</tbody>
								</table>
								@endif
				      </div>
						</div>
				    </div>
					</div>
				</div>
			</div>
		</div>	
	</div>
</div>

<!-- MODALS -->
<div class="modal fade" id="confirm_medical_billing" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirm Payment?</h4>
			</div>
			<div class="modal-body">
				<table id="displayMedicalBillingTableModal" class="table" style="display: none">
					<tbody id="displayMedicalBillingModal">
					</tbody>
				</table>
			<div class="row">
				<div class="col-md-6 col-md-offset-6">
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">Total</span>
					  <input type="text" class="form-control" id="display_amount_modal_medical" aria-describedby="basic-addon1" disabled style="background-color:white;">
					</div>
				</div>
			</div>
			</div>
			<div class="modal-footer text-center">
				<div class="pull-left">
					<button type="button" class="btn btn-primary" id="printMedicalReceiptButton">Print Receipt</button>
				</div>
				<button type="button" class="btn btn-primary" id="addMedicalBillingButton">Confirm</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>

<div class="modal fade" id="confirm_dental_billing" role="dialog">
	<div class="modal-dialog">
		<!-- Modal content-->
		<div class="modal-content">
			<div class="modal-header">
				<h4 class="modal-title">Confirm Payment?</h4>
			</div>
			<div class="modal-body">
				<table id="displayDentalBillingTableModal" class="table" style="display: none">
					<tbody id="displayDentalBillingModal">
					</tbody>
				</table>
			<div class="row">
				<div class="col-md-6 col-md-offset-6">
					<div class="input-group">
					  <span class="input-group-addon" id="basic-addon1">Total</span>
					  <input type="text" class="form-control" id="display_amount_modal_dental" aria-describedby="basic-addon1" disabled style="background-color:white;">
					</div>
				</div>
			</div>
			</div>
			<div class="modal-footer text-center">
				<div class="pull-left">
					<button type="button" class="btn btn-primary" id="printDentalReceiptButton">Print Receipt</button>
				</div>
				<button type="button" class="btn btn-primary" id="addDentalBillingButton">Confirm</button>
				<button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
			</div>
		</div>
	</div>
</div>
@endsection