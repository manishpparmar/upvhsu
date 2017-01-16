<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Auth;
use App\DentalSchedule;
use App\DentalAppointment;
use App\DentalRecord;
use App\Patient;
use DB;

class DentistController extends Controller
{
	public function __construct()
		{
			$this->middleware(function ($request, $next) {
				if(Auth::check()){
					if(Auth::user()->user_type_id == 2 and Auth::user()->staff->staff_type_id == 1){
					return $next($request);
				}
				}
				else{
					return redirect('/');
				}
		});
		}
		public function dashboard()
		{
				$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'dashboard';
				$user = Auth::user();
				$dental_appointments_fin = DB::table('dental_schedules')
						->join('dental_appointments', 'dental_schedules.id', '=', 'dental_appointments.dental_schedule_id')
						->join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')
						->where('dental_schedules.staff_id', '=', $user->user_id)
						->get();

				return view('staff.dental-dentist.dashboard', $params, compact('dental_appointments_fin'));
		}

		public function addrecord(Request $request)
		{
			$appointment_id = $request->appointment_id;
			$dental_appointment_info = DB::table('dental_appointments')
						->join('patient_info', 'dental_appointments.patient_id', '=', 'patient_info.patient_id')
						->join('dental_schedules', 'dental_appointments.dental_schedule_id', '=', 'dental_schedules.id')
						->where('dental_appointments.id', '=', $appointment_id)
						->first();

			$schedule_start = date_create($dental_appointment_info->schedule_start);
			$dental_appointment_info->schedule_start = date_format($schedule_start,"H:i:s");
			$schedule_end = date_create($dental_appointment_info->schedule_end);
			$dental_appointment_info->schedule_end = date_format($schedule_end,"H:i:s");
			return response()->json(['dental_appointment_info' => $dental_appointment_info]); 
		}

		public function addrecordperteeth(Request $request)
		{
			$appointment_id = $request->appointment_id;
			$teeth_id = $request->teeth_id;

			// $display_latest_dental_record = DB::table('dental_records')
			// 			->where('appointment_id', '=', $appointment_id)
			// 			->where('teeth_id', '=', $teeth_id)
			// 			->orderBy('created_at', 'desc')
			// 			->first();
 
			return response()->json(['appointment_id' => $appointment_id, 'teeth_id' => $teeth_id]); 
		}

		public function updaterecordperteeth(Request $request)
		{
			$appointment_id = $request->appointment_id;
			$teeth_id = $request->teeth_id;
			$condition_id = $request->condition_id;
			$operation_id = $request->operation_id;

			DB::table('dental_records')->insert([
			    [	'appointment_id' => $request->appointment_id, 
			    	'teeth_id' => $request->teeth_id,
			    	'condition_id' => $request->condition_id,
			    	'operation_id' => $request->operation_id,
			    	'created_at' =>  date('Y-m-d H:i:s')
			    ],
			]);

			return response()->json(['success' => 'success']); 
		}

		public function profile()
		{
				$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'profile';
			return view('staff.dental-dentist.profile', $params);
		}

		public function manageschedule()
		{
				$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'manageschedule';
			return view('staff.dental-dentist.manageschedule', $params);
		}

		public function searchpatient()
		{
				$params['navbar_active'] = 'account';
			$params['sidebar_active'] = 'searchpatient';
			return view('staff.dental-dentist.searchpatient', $params);
		}

		public function addschedule(Request $request)
		{
				$schedules = $request->schedules;
				for($i=0; $i < sizeof($schedules); $i++){
						$explode_schedules = explode(";;;", $schedules[$i]);
						$start = $explode_schedules[0];
						$end = $explode_schedules[1];
						$schedule = new DentalSchedule();
						$schedule->staff_id = Auth::user()->user_id;
						$schedule->schedule_start = $start;
						$schedule->schedule_end = $end;
						$schedule->save();
				}
				
				return response()->json(['success' => 'success']); 
		}
}
