<?php

namespace App\Http\Controllers;

use App\Models\LatestNews;
use App\Models\UserPrivilege;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class LatestNewsController extends Controller
{
 

    public function index()
    {
        $data= Auth::guard('admin')->user();
        $datas = LatestNews::query()->where('status','!=','delete')->paginate(5);
        $plv= UserPrivilege::query()->where(['username'=> $data->username, 'status'=> "active"])->get();
        return view('admin.newsfeed',compact('datas','plv'));
    }


    public function newsOperation($val,$token)
    {
        LatestNews::query()->where('token',$token)->update(['status'=> $val]);
        return back();
    }

}
