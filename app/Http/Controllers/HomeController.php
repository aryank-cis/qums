<?php

namespace App\Http\Controllers;

use App\Models\{Departments, QuerySubmission, User, Timeline};
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Mail;

class HomeController extends Controller
{

	public function index()
	{
		$departments = Departments::orderBy('name', 'ASC')
			->whereNotIn('name', ['Super Admin', 'Users'])
			->get(['id', 'name']);
		return view('home', compact('departments'));
	}


	public function querySubmission(Request $request)
	{

		$departments = Departments::orderBy('name', 'ASC')
			->whereNotIn('name', ['Super Admin', 'Users'])
			->get(['id', 'name']);
		return view('welcome', compact('departments'));
	}

	public function searchSubmission(Request $request)
	{
		try {

			$users = User::where('department', $request->department)->get(['id', 'name']);
			if (!$users) {
				return response()->json(['status' => false, 'msg' => 'Users not found!'], 404);
			}
			return response()->json(['status' => true, 'msg' => 'Form Data', 'data' => $users], 200);
		} catch (\Exception $exception) {


			return response()->json(['status' => false, 'error' => $exception->getMessage()], 500);
		}
	}
	public function queryFormSubmission(Request $request)
	{
		try {

			$validation = Validator::make($request->all(), [
				'name' => 'required|Max:255',
				'email' => 'required|email',
				'departments' => 'required|integer',
				'message' => 'required',
				'query_for' => 'required'

			]);

			if ($validation->fails()) {

				return response()->json(['status' => false, 'error' => $validation->errors()], 422);
			}

			$QuerySubmission = new QuerySubmission();
			$QuerySubmission->name = $request->name;
			$QuerySubmission->email = $request->email;
			$QuerySubmission->query_content = $request->message;
			$QuerySubmission->query_type = $request->departments;
			$QuerySubmission->query_for = $request->query_for;
			$QuerySubmission->query_status = 0;
			$QuerySubmission->status = 0;
			$QuerySubmission->query_to = auth()->user()->id;
			$queryID = rand(10000000, 99999999);
			$QuerySubmission->query_id = $queryID;
			$QuerySubmission->save();




			// // Send Email
			// $data = [
			// 	'name' => $request->name,
			// 	'email' => $request->email,
			// 	'message' => $request->message,
			// 	'department' => Departments::find($request->departments)->name,
			// 	'queryID' => $queryID,
			// 	'query_for' => $request->query_for
			// ];
			// Mail::send('emails.querySubmission', $data, function ($message) use ($request) {
			// 	$message->to($request->email)->subject('Query Submitted');
			// });



			// Timeline 
			$timeline = new Timeline();
			$timeline->user_id = auth()->user()->id;
			$timeline->stage = 1;
			$timeline->query_id = $QuerySubmission->id;
			$timeline->status = 1;
			$timeline->save();

			return response()->json(['status' => true, 'message' => 'Query  Submitted Successfully', 'QueryID' => $queryID], 200);
		} catch (\Exception $ex) {

			return response()->json(['status' => false, 'error' => $ex->getMessage()], 500);
		}
	}
}
