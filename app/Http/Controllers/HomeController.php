<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use App\Http\Controllers\Json;
use Yajra\Datatables\Datatables;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Config;
// Database models import class files
use App\Users;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct() {
        $this->middleware('auth')->except('userDetails');
    }

    /**
     * Show the application dashboard.
     *
     * @return Renderable
     */
    public function index()
    {
        return view('home');
    }

    /**
     * @param Request $request
     * @return JsonResponse
     * @author Gaurang Joshi <gaurangnil@gmail.com>
     * @throws Exception
     */
    public function datatableList(Request $request) {
        try {
            $search = $request->input('search', array('value' => null))['value'];
            $offset = $request->input('start', Config::get('constants.default.db_offset'));
            $limit = $request->input('length', Config::get('constants.default.db_limit'));
            $order_by_direction = $request->input('order', array(array('column' => 0, 'dir' => 'asc')))[0]['dir'];
            $order_by_col_number = $request->input('order', array(array('column' => 0, 'dir' => 'asc')))[0]['column'];
            $order_by_column_key = $request->input('columns', array(array('name' => 'id')))[$order_by_col_number]['name'];
            $users_query = 'select id, name, email from users where id !="' . auth()->user()->id . '"';
            if (!empty($search)) {
                $users_query .= ' and (name like "%' . $search . '%" or email like "%' . $search . '%")';
            }
            $users_query .= ' order by ' . $order_by_column_key . ' ' . $order_by_direction;
            $before_limit_users_query = $users_query;
            $users_query .= ' limit ' . $limit . ' offset ' . $offset;
            $users = DB::select(DB::raw($users_query));
            foreach ($users AS $user) {
                $user->action = '<a href="#" name="user-id" id="'.$user->id.'">Details</a>';
            }
            $filtered_total_records = count(DB::select(DB::raw($before_limit_users_query)));
            $total_records = Users::count();
            $datatable_response = array(
                'draw' => $request->input('draw'),
                'recordsTotal' => $total_records,
                'recordsFiltered' => $filtered_total_records,
                'data' => $users,
            );
            return response()->json($datatable_response);
//            return DataTables::of($users)
//                ->setTotalRecords($total_records)->setFilteredRecords($filtered_total_records)->make();
        } catch (Exception $e) {
            return response()->json(Json::exception_response(['msg' => $e->getMessage()], trans('messages.general.error')));
        }
    }

    /**
     * @param Request $request
     * @return JsonResponse
     */
    public function userDetails(Request $request) {
        try {
            $id = $request->input('id', null);
            if(!empty($id)) {
                $user_details = Users::whereId($id)->get()->first()->toArray();
                return response()->json(Json::response($user_details, trans('messages.general.success')));
            } else {
                return response()->json(Json::not_found_response(['message' => trans('constants.general.error')]));
            }
        } catch (Exception $e) {
            return response()->json(Json::exception_response(['exception_message' => $e->getMessage()], trans('messages.general.error')));
        }
    }
}
