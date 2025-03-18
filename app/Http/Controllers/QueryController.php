<?php

namespace App\Http\Controllers;

use App\Models\{Departments, QuerySubmission, User, Timeline};
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Validator;
use Mail;


class QueryController extends Controller
{

	public function index(Request $request)
	{
		try {
			$query = QuerySubmission::with('queryUser', 'QueryDepartment')->orderBy("id", "desc");
			if (auth()->user()->department != 1) {

				$query->where("query_for", auth()->user()->id);
			}
			$queryList = $query->get();
			return view("query.index", compact("queryList"));
		} catch (\Exception $e) {
			return notify()->error($e->getMessage());
		}
	}
	public function toQueries(Request $request)
	{
		try {
			$query = QuerySubmission::with('queryUser', 'QueryDepartment')->orderBy("id", "desc");
			$query->where("query_to", auth()->user()->id);
			$queryList = $query->get();
			return view("query.toQuersies", compact("queryList"));
		} catch (\Exception $e) {

			return notify()->error($e->getMessage());
		}
	}


	public function ShowQueryList(Request $request)
	{
		// dd($request->all());

		try {
			$query = QuerySubmission::with('queryUser', 'QueryDepartment')->orderBy("id", "desc");

			if (auth()->user()->department != 1) {
				$query->where("query_for", auth()->user()->id);
			}

			if ($request->department) {
				$query->where("query_type", $request->department);
			}

			if ($request->QueryMember) {
				$query->where("query_for", $request->QueryMember);
			}

			if ($request->queryStatus) {
				$query->where("query_status", $request->queryStatus);
			}

			if ($request->searchbyID) {
				$query->where("query_id", $request->searchbyID);
			}
			if ($request->queryFilter == 'query_for') {
				$query->where("query_for", auth()->user()->id);
			}
			if ($request->queryFilter == 'query_to') {
				$query->where("query_to", auth()->user()->id);
			}
			$start = $request->input('start', 0);
			$length = $request->input('length', 10);
			$draw = $request->input('draw', 1);
			$paginatedData = $query->skip($start)->take($length)->get();
			$totalRecords = QuerySubmission::count();
			$filteredRecords = $query->count();

			$response = [
				"draw" => intval($draw),
				"recordsTotal" => $totalRecords,
				"recordsFiltered" => $filteredRecords,
				"data" => $paginatedData
			];

			return response()->json($response, 200);

		} catch (\Exception $e) {
			return response()->json(['error' => $e->getMessage()], 500);
		}
	}


	public function queryShow(Request $request, $id)
	{

		try {
			$query = QuerySubmission::with('queryUser')->find($id);
			return view("query.queryShow", compact("query"));
		} catch (\Exception $e) {
			notify()->error("Server Error: " . $e->getMessage());
			return redirect()->back();
		}
	}
	public function QueryAction(Request $request)
	{
		try {
			$query = QuerySubmission::find($request->queryID);
			$query->query_status = $request->query_status;
			$query->query_closer_comment = $request->query_resolution;
			$query->save();



			// Timeline
			$timeline = new Timeline();
			$timeline->user_id = auth()->user()->id;
			$timeline->query_id = $request->queryID;
			$timeline->stage = 2;
			$timeline->status = 1;
			$timeline->save();


			notify()->success("Query status updated.");
			return redirect()->back();
		} catch (\Exception $e) {
			notify()->error("Server Error: " . $e->getMessage());
			return redirect()->back();
		}
	}

	public function QueryUserAction(Request $request)
	{
		try {
			$query = QuerySubmission::find($request->queryID);
			$query->status = $request->query_status;
			$query->query_raiser_comment = $request->query_resolution;
			$query->save();



			// Timeline
			$timeline = new Timeline();
			$timeline->user_id = auth()->user()->id;
			$timeline->query_id = $request->queryID;
			$timeline->stage = 3;
			$timeline->status = 1;
			$timeline->save();


			notify()->success("Query status updated.");
			return redirect()->back();
		} catch (\Exception $e) {
			notify()->error("Server Error: " . $e->getMessage());
			return redirect()->back();
		}
	}

	public function QueryRemove(Request $request, $id)
	{
		try {

			$query = QuerySubmission::find($id);
			if (!$query) {
				notify()->error("Query not found");
				return redirect()->back();
			}
			$query->delete();

			// Timeline
			$timeline = new Timeline();
			$timeline->user_id = auth()->user()->id;
			$timeline->query_id = $id;
			$timeline->stage = 2;
			$timeline->status = 1;
			$timeline->save();
			notify()->success("Query deleted successfully");
			return redirect()->back();
		} catch (\Exception $e) {

			notify()->error("Server Error: " . $e->getMessage());
			return redirect()->back();
		}
	}

	public function filter(Request $request)
	{

		try {
			$query = QuerySubmission::query();

			if ($request()->filled('department')) {
				$query->where('query_for', $request('department'));
			}
			if ($request()->filled('status')) {
				$query->where('query_status', $request('status'));
			}
			if ($request()->filled('created_at')) {
				$query->whereBetween('created_at', [$request('created_at') . '00:00:00', $request('created_at') . '23:59:59']);
			}
			$queryList = $query->with('queryUser', 'QueryDepartment')->orderBy("id", "desc")->get();
			return view('query.index', compact('queryList'));
		} catch (\Exception $e) {
			notify()->error('Server Error: ' . $e->getMessage());
			return redirect()->back();
		}
	}
}
