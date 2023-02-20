<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Validator;
use Session;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('guest')->except('logout');
        $this->middleware('guest:admin')->except('logout');
    }

    public function index()
    {
        return view('admin.login');
    }

    public function adminLogin(Request $request)
    {
        try {
            $validator = Validator::make($request->all(), [
                'emailAddress'   => 'required|email|exists:admins,email',
                'password' => 'required'
            ]);

            if ($validator->fails()) {
                return back()->withInput()->with('error', $validator->messages()->first());
            }
            
            $data= Admin::where('email',$request->emailAddress)->first();  

                switch ($data->status) {
                    case 'active':
                    if (Auth::guard('admin')->attempt([
                                    'email' => $request->emailAddress, 
                                    'password' => $request->password,
                                ])){
                            $request->session()->regenerate();
                        return back()
                            ->withInput($request->only('emailAddress'))
                            ->with('success','Login successful, Welcome back!');
                        }else{
                            return back()->with('error','The provided credentials does not match our records.')->onlyInput('emailAddress');
                            }
                        break;
                    case 'suspended':
                        return redirect()->back() 
                            ->withInput($request->only('emailAddress'))
                            ->with('error','Oops!, Account has been suspended');
                        break;
                    default:
                        return redirect()->back()
                            ->withInput($request->only('emailAddress'))
                            ->with('error','oops!, Unknown credentials');
                        break;
                    }        
            return redirect()->back()
                    ->withInput($request->only('emailAddress'))
                    ->with('error','Invalid credentials');
        } catch (\Exception $e) {
            return redirect()->back()
                            ->withInput($request->only('emailAddress'))
                            ->with('error',$e->getMessage());
        }
    }

    public function logout() 
    {
        Session::flush();
        Auth::guard('admin')->logout();   
        return redirect('/admin');
    }
}
