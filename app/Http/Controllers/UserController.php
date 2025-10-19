<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\UserGroup;
use App\Models\Process;
use App\Models\Customer;
use App\Models\Vendor;
use App\Exports\UsersExport;
use App\Jobs\ImportUser;
use App\Models\Setting;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;
use App\Exports\StatistikumumPaketExport;
use App\Exports\StatistikumumBagianExport;
use App\Exports\StatistikumumClientExport;
  
/**
 * Description of UserController
 *
 * @author In House Dev Program
 */
class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
	public function __construct()
    {
        $this->middleware('auth');
    }  
	 
    public function index()
    {
        $customers = Customer::where('active', 'Y')->get();
        $vendor = Vendor::where('active', 'Y')->get();
        $process = Process::where('upload','user')->where('status','ON PROGRESS')->first();
        $userGroup = UserGroup::where('active', 'Y')->get();
        return $this->view('pages.user.index','Users','users', ['process' => $process, 'userGroup' => $userGroup, 'customers' => $customers, 'vendor' => $vendor]);
    }

    /**
     * Show user profile
     *
     * @return type
     */
    public function profile()
    {
        return view('pages.user.profile');
    }

    /**
     * Change password form
     *
     * @return type
     */
    public function changePassword()
    {
        return view('pages.user.change-password');
    }

    /**
     * Setting form
     *
     * @return void
     */
    public function setting()
    {
        return view('pages.user.setting');
    }

    /**
     * Submit change password
     *
     * @param Request $request
     * @return type
     */
    public function storeChangePassword(Request $request)
    {
        if($request->password != $request->repassword) {
            return back()->with('error', 'Password doesn\'t match');
        }

        $user = User::where('id', Auth::user()->id)->first();
        $user->password = Hash::make($request->password);
        if(!$user->save()) {
            return back()->with('error', 'Failed to update password. Please try again');
        }

        return back()->with('success', 'Password has been changed');
    }

    /**
     * Setting
     *
     * @param Request $request
     * @return void
     */
    public function storeSetting(Request $request)
    {
        $setting = Setting::updateOrCreate(
            ['user_id' => Auth::user()->id],
            ['language' => $request->language]
        );

        if(!$setting->save()) {
            return back()->with('error', 'Failed to update setting. Please try again');
        }

        Session::put('app-locale', Auth::user()->setting->language);

        return back()->with('success', 'Setting has been update');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $u = new User();
        $u->email = $request->email;
        $u->name = $request->name;
        $u->password = Hash::make($request->password);
        $u->user_group_id = $request->group;
        $u->customer_id = $request->customer;
        $u->vendor_id = $request->vendor;
        $u->active = $request->active;

        if(!$u->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t add user. Please try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'User has been added successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function show(User $user, $id)
    {
        $u = $user->find($id);
        return response()->json($u);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, User $user)
    {
        $u = $user->find($request->id);
        $u->email = $request->email;
        $u->name = $request->name;
        $u->user_group_id = $request->group;
		if($request->group == 2) //vendor
		{
		    $u->customer_id = null;
			$u->vendor_id = $request->vendor;
        	
		}
		else if ($request->group == 3) //cs
		{
			$u->customer_id = $request->customer;
            $u->vendor_id = null;
		}
		else if ($request->group == 1) //admin
		{
			$u->customer_id = null;
            $u->vendor_id = null;

		}
		else
		{
			$u->customer_id = null;
            $u->vendor_id = null;
		}
        $u->active = $request->active;

        if(!empty($request->password)) {
            $u->password = Hash::make($request->password);
        }

        if(!$u->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t update user. Please try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'User has been updated successfully']);
    }

    /**
     * Update profile
     *
     * @param Request $request
     * @return type
     */
    public function updateProfile(Request $request)
    {
        // Check is email exists
        $u = User::where('email', $request->email);
        if($u->count() > 0 && ($u->first()->id != Auth::user()->id)) {
            return back()->with('error', 'Email used by another user');
        }

        $up = User::find(Auth::user()->id);
        $up->email = $request->email;
        $up->name = $request->name;

        if ($request->hasFile('file')) {
            $file = $request->file('file');
            if($file->isValid()) {
                $nameStripped = str_replace(" ", "-", $file->getClientOriginalName());
                $file->storeAs('user', $nameStripped);
                $up->avatar = $nameStripped;

                // Set session avatar
                session()->put('user.avatar', $nameStripped);
            }
        }

        if(!$up->save()) {
            return back()->with('error', 'Failed to update profile');
        }

        // Set updated session
        session()->put('user.name', $request->name);
        session()->put('user.email', $request->email);

        return back()->with('success', 'Profile has been updated');

    }


    /**
     * Activate user
     *
     * @param User $user
     * @param type $id
     * @return type
     */
    public function activateUser(User $user, $id)
    {
        $u = $user->find($id);
        $u->active = 'Y';

        if(!$u->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t activate user. Please try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'User has been activated successfully']);
    }

    /**
     * Inactivate user
     *
     * @param User $user
     * @param type $id
     * @return type
     */
    public function inactivateUser(User $user, $id)
    {
        $u = $user->find($id);
        $u->active = 'N';

        if(!$u->save()) {
            return response()->json(['responseCode' => 500, 'responseStatus' => 'Failed', 'responseMessage' => 'Can\'t inactivate user. Please try again']);
        }

        return response()->json(['responseCode' => 200, 'responseStatus' => 'OK', 'responseMessage' => 'User has been inactivated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        //
    }

    /**
     * User datatables
     *
     * @return type JSON user
     */
    public function datatables()
    {
        $users = User::with(['userGroup', 'customer','vendor']);
       
        return datatables($users)
            ->addColumn('action', function($users) {

                if($users->active == 'Y') {
                    $btnActive = '<button class="btn btn-default btn-xs btn-inactive" data-id='.$users->id.'><i class="fa fa-ban"></i></button>';
                } else {
                    $btnActive = '<button class="btn btn-default btn-xs btn-active" data-id='.$users->id.'><i class="fa fa-check-circle"></i></button>';
                }

                return '<button type="button" class="btn btn-warning btn-xs btn-edit" data-id='.$users->id.'><i class="fa fa-pencil"></i></button>&nbsp; '.$btnActive;
            })
            ->addColumn('active', function($users){
                return ($users->active == 'Y')?'<span class="text-success">Yes</span>':'<span class="text-danger">No</span>';
            })
            ->rawColumns(['action', 'active'])
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Export users
     *
     * @return type file .xlsx
     */
    public function export()
    {
        return Excel::download(new UsersExport, 'users.xlsx');
    }

    public function statistik_umum_paket_export($orderPaket=null,$filterPaket=null)
    {
     
        $orderPaket = explode(",", $orderPaket);
        $filterPaket = explode("&", $filterPaket);
      
        $perusahaan= explode("=",$filterPaket[0]);
        $vendor= explode("=",$filterPaket[1]);
        $client= explode("=",$filterPaket[2]);
        $startDate= explode("=",$filterPaket[3]);
        $endDate= explode("=",$filterPaket[4]);
        $search =  explode("=",$filterPaket[5]);
        
        $kolom = '';
        if($orderPaket[0]==0)
        {
            $kolom = 'paket_mcu';
        }
        else if($orderPaket[0]==1)
        {
            $kolom = 'total';
        }

        $order = $orderPaket[1];
       
        $perusahaan = $perusahaan[1];
        $vendor = $vendor[1];
        $client = $client[1];
        $startDate = $startDate[1];
        $endDate = $endDate[1];
        $search = $search[1];

        //echo $search;
        
        return Excel::download(new StatistikumumPaketExport($kolom,$order,$perusahaan,$vendor,$client,$startDate,$endDate,$search), 'statistik_umum_paket_export.xlsx');
    }

    public function statistik_umum_bagian_export($orderPaket=null,$filterPaket=null)
    {
        
        $orderPaket = explode(",", $orderPaket);
        $filterPaket = explode("&", $filterPaket);
      
        $perusahaan= explode("=",$filterPaket[0]);
        $vendor= explode("=",$filterPaket[1]);
        $client= explode("=",$filterPaket[2]);
        $startDate= explode("=",$filterPaket[3]);
        $endDate= explode("=",$filterPaket[4]);
        $search =  explode("=",$filterPaket[5]);
        
        $kolom = '';
        if($orderPaket[0]==0)
        {
            $kolom = 'bagian';
        }
        else if($orderPaket[0]==1)
        {
            $kolom = 'total';
        }

        $order = $orderPaket[1];
       
        $perusahaan = $perusahaan[1];
        $vendor = $vendor[1];
        $client = $client[1];
        $startDate = $startDate[1];
        $endDate = $endDate[1];
        $search = $search[1];

        return Excel::download(new StatistikumumBagianExport($kolom,$order,$perusahaan,$vendor,$client,$startDate,$endDate,$search), 'statistik_umum_bagian_export.xlsx');
    }

    public function statistik_umum_client_export($orderPaket=null,$filterPaket=null)
    {
        
        $orderPaket = explode(",", $orderPaket);
        $filterPaket = explode("&", $filterPaket);
      
        $perusahaan= explode("=",$filterPaket[0]);
        $vendor= explode("=",$filterPaket[1]);
        $client= explode("=",$filterPaket[2]);
        $startDate= explode("=",$filterPaket[3]);
        $endDate= explode("=",$filterPaket[4]);
        $search =  explode("=",$filterPaket[5]);
        
        $kolom = '';
        if($orderPaket[0]==0)
        {
            $kolom = 'client';
        }
        else if($orderPaket[0]==1)
        {
            $kolom = 'total';
        }

        $order = $orderPaket[1];
       
        $perusahaan = $perusahaan[1];
        $vendor = $vendor[1];
        $client = $client[1];
        $startDate = $startDate[1];
        $endDate = $endDate[1];
        $search = $search[1];
        return Excel::download(new StatistikumumClientExport($kolom,$order,$perusahaan,$vendor,$client,$startDate,$endDate,$search), 'statistik_umum_client_export.xlsx');
    }
    
    /**
     * Import users
     *
     * @param Request $request
     * @return type database
     */
    public function import(Request $request)
    {
        if ($request->hasFile('file')) {

            $file = $request->file('file');
            $processId = null;

            if($file->isValid()) {
                $nameStripped = str_replace(" ", "-", $file->getClientOriginalName());
                $file->storeAs('upload', $nameStripped);

                // Push into process
                $process = new Process();
                $process->fill([
                    'upload'    => 'user',
                    'processed' => 0,
                    'success'   => 0,
                    'failed'    => 0,
                    'total'     => 100,
                    'status'    => 'ON PROGRESS'
                ]);
                $process->save();

                $processId = $process->id;

                ImportUser::dispatch('upload'.DIRECTORY_SEPARATOR.$nameStripped, $process->id)->delay(now()->addSeconds(10));
            }

            return response()->json([
                'responseCode' => 200,
                'responseMessage' => 'Uploaded',
                'processId' => $processId
            ]);
        }
    }
}
