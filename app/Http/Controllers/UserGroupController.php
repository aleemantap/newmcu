<?php

namespace App\Http\Controllers;

use App\Models\UserGroup;
use App\Models\Menu;
use Illuminate\Http\Request;

class UserGroupController extends Controller
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
        $menus = Menu::where('parent_id', null)->orderBy('sequence')->get();
        return $this->view('pages.user-group.index', 'User Group','Role',['menus' => $menus]);
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
        $d = new UserGroup();
        $d->name = $request->groupName;
        $d->description = $request->groupDescription;

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to create or update user group']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'User group has been created or updated successfully']);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return response()->json(UserGroup::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function edit(UserGroup $userGroup)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $d = UserGroup::find($request->groupId);
        $d->name = $request->groupName;
        $d->description = $request->groupDescription;

        if(!$d->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update user group']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'User group has been updated successfully']);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\UserGroup  $userGroup
     * @return \Illuminate\Http\Response
     */
    public function destroy(UserGroup $userGroup)
    {
        //
    }

    /**
     * User group datatables
     *
     * @return type JSON user
     */
    public function datatables()
    {
        $userGroups = UserGroup::all();

        return datatables($userGroups)
            ->addColumn('action', function($userGroups) {
                // if user inactive
                if($userGroups->active == 'Y') {
                    $btnDisable = '<button class="btn btn-default btn-xs btn-disable" title="Disable user group" data-id="'.$userGroups->id.'"><i class="fa fa-fw fa-ban"></i></button>';
                } else {
                    $btnDisable = '<button class="btn btn-default btn-xs btn-active" title="Activate user group" data-id="'.$userGroups->id.'"><i class="fa fa-fw fa-check-circle"></i></button>';
                }

                return '<button type="button" class="btn btn-default btn-xs btn-privileges" title="Set privileges" data-id='.$userGroups->id.'><i class="fa fa-gear"></i></button> &nbsp; <button type="button" class="btn btn-warning btn-xs btn-edit" title="Edit user group" data-id='.$userGroups->id.'><i class="fa fa-pencil"></i></button>&nbsp; '.$btnDisable;
            })
            ->addIndexColumn()
            ->toJson();
    }

    /**
     * Disable user group
     *
     * @param type $id
     * @return type
     */
    public function disableUserGroup($id)
    {
        $userGroup = UserGroup::find($id);
        $userGroup->active = 'N';

        if(!$userGroup->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Failed to disable user group']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'User group has been disable successfully']);
    }

    /**
     * Activate user group
     *
     * @param type $id
     * @return type
     */
    public function activateUserGroup($id)
    {
        $userGroup = UserGroup::find($id);
        $userGroup->active = 'Y';

        if(!$userGroup->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Failed to activate user group']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'User group has been activated successfully']);
    }
    
    /**
     * Set privileges
     * 
     * @param type $id
     * @return type json menu actions
     */
    public function getPrivileges($id)
    {
        $userGroup = UserGroup::find($id);
        return response()->json(['responseCode' => 200, 'responseMessage' => 'Fetch user group privileges successfully', 'result' => $userGroup->menuActions]);
    }
    
    public function storePrivileges(Request $request)
    {
        $userGroup = UserGroup::find($request->userGroupId);
        $userGroup->menuActions()->detach();
        $userGroup->menuActions()->attach($request->menuActions);
        
        return response()->json(['responseCode' => 200, 'responseMessage' => 'Privileges has been set successfully']);
    }
}
