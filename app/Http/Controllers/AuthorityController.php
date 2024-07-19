<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\UrlModel;
use App\Models\AuthorityModel;
use App\Models\User;
use App\Models\IterinaryRevisedLogModel;
use App\Models\IterinaryLog;
use DataTables;

class AuthorityController extends Controller
{
    public function authority(Request $request){
        if($request->type === "link"){
            UrlModel::create([
                'linkName'   => $request->name,
            ]);
            return back()->with('success', 'Added');
        }
        // ----------------
        if($request->type === "add_access"){
            AuthorityModel::create([
                'linkName_id'   => $request->linkName_id,
                'user_id'        => $request->id,
            ]);
            return 'success';
        }
         // ---------------- remove access
         if($request->type === "remove_access"){
            AuthorityModel::where('linkName_id', $request->linkName_id)->where('user_id',$request->id)->delete();
            return 'success';
         }
        // ----------------
        if($request->ajax() and $request->type === "url") {
            return datatables()->of(UrlModel::orderBy('id','asc')->get())
            ->addColumn('action', function ($row) {
                $html = "<a href='#' class='btn btn-danger btn-sm'>Delete</a>";
                $html = $html  . "<a href='#' onclick='#' class='btn btn-success btn-sm'>Edit</a>";
                return $html;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }
        // -----------------
        if($request->ajax() and $request->type === "employee") {
            return datatables()->of(User::get())
            ->addColumn('action', function ($row) {
                $html = "<a href='#' onclick='edit(".$row->id.")' class='btn btn-success btn-sm'>Add Access</a>";
                return $html;
            })
            ->addColumn('access', function ($row) {
                $list = "";
                $authority = AuthorityModel::where('user_id', $row->id)
                                            ->join('table_urls','table_urls.id','=','authority.linkName_id')
                                            ->get();
                foreach($authority as $item){
                    $list = $list.$item->linkName.', ';
                }
                return $list;
            })
            ->rawColumns(['action'])
            ->addIndexColumn()
            ->make(true);
        }

        $data = UrlModel::get();
        return view('pages.authority.index', compact('data'));
    }

    public function revise_itirenary(Request $request){
        if($request->type == "disapproved"){
            IterinaryRevisedLogModel::where('id', $request->id)
                                    ->update([
                                        'is_approved' => 10
                                    ]);
        }
        if($request->type == "approved"){
            IterinaryRevisedLogModel::where('id', $request->id)
                                    ->update([
                                        'is_approved' => 1
                                    ]);
        }
        if ($request->ajax()) {
            $data = IterinaryRevisedLogModel::where('is_approved', 0)->get();
            
            return DataTables::of($data)
                ->addColumn('action', function ($row) {
                    // check for revision
                    $html = "<i class='fa-solid fa-check text-success h5' onclick='approve(".$row->id.")'  style='cursor: pointer;' ></i> &nbsp;&nbsp;&nbsp;";
                    $html = $html."<i class='fa-solid fa-ban text-danger h5' onclick='dele(".$row->id.")' style='cursor: pointer;'></i>";
                    return $html;
                })
                ->addColumn('request_by', function ($row) {
                    $name = User::where('id',$row->user_id)->first();
                    return $name->name;
                })
                ->addColumn('name', function ($row) {
                    $log = IterinaryLog::where('id',$row->itirenary_log_id)->first();
                    $name = User::where('id',$log->user_id)->first();
                    return $name->name;
                })
                ->addColumn('locationText', function ($row) {
                    $log = IterinaryLog::where('id',$row->itirenary_log_id)->first();
                    return "<small>".$row->location." (new)<br><hr>".$log->location." (old)</small>";
                })
                ->addColumn('dateText', function ($row) {
                    $log = IterinaryLog::where('id',$row->itirenary_log_id)->first();
                    return "<small>".date("M d, Y", strtotime($row->date))." (new)<br><hr>".date("M d, Y", strtotime($log->date))." (old)</small>";
                })
                ->addColumn('timeInText', function ($row) {
                    $log = IterinaryLog::where('id',$row->itirenary_log_id)->first();
                    return "<small>".date("h:i A", strtotime($row->time_in))." (new)<br><hr>".date("h:i A", strtotime($log->time_in))." (old)</small>";
                })
                ->addColumn('timeOutText', function ($row) {
                    $log = IterinaryLog::where('id',$row->itirenary_log_id)->first();
                    return "<small>".date("h:i A", strtotime($row->time_out))." (new)<br><hr>".date("h:i A", strtotime($log->time_out))." (old)</small>";
                })
                ->rawColumns(['action','dateText','timeInText','timeOutText','locationText'])
                ->make(true);
        }

        return view('pages.revise_itirenary.index');

    }
}
