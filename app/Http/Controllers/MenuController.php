<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Models\MenuAction;
use Illuminate\Http\Request;

class MenuController extends Controller
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
        return $this->view('pages.menu.builder','Menu','Menu', [
            'menus' => Menu::doesntHave('parent')->orderBy('sequence')->get()
        ]);
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
     * Store a new item to menu
     *
     * @param Request $request
     * @return type
     */
    public function store(Request $request)
    {
        $menu = new Menu();
        $menu->name = $request->menuName;
        $menu->tooltip = $request->tooltip;
        $menu->description = $request->description;
        $menu->icon = $request->icon;
        $menu->action_url = $request->url;
        $menu->sequence = $request->squence;

        if(!$menu->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to add menu item']);
        }

        foreach ($request->actions as $action) {
            MenuAction::updateOrCreate(
                [
                    'menu_id' => $menu->id,
                    'action_type' => $action
                ],
                [
                    'is_visible' => 'Y'
                ]
            );
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Menu item been added successfully', 'result' => $menu]);
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $menu = Menu::where('id', $id)->with('actions')->first();
        return response()->json($menu);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function edit(Menu $menu)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $menu = Menu::find($request->menuId);
        $menu->name = $request->menuName;
        $menu->tooltip = $request->tooltip;
        $menu->description = $request->description;
        $menu->icon = $request->icon;
        $menu->action_url = $request->url;
        $menu->sequence = $request->squence;

        if(!$menu->save()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to update menu item']);
        }

        // Reset actions
        MenuAction::where('menu_id', $menu->id)->delete();

        foreach ($request->actions as $action) {
            MenuAction::updateOrCreate(
                [
                    'menu_id' => $menu->id,
                    'action_type' => $action
                ],
                [
                    'is_visible' => 'Y'
                ]
            );
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Menu item been updated successfully', 'result' => $menu]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Menu  $menu
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $menuItem = Menu::find($id);

        if(!$menuItem->delete()) {
            return response()->json(['responseCode' => 500, 'responseMessage' => 'Unable to delete menu item']);
        }

        return response()->json(['responseCode' => 200, 'responseMessage' => 'Menu item has been deleted successfully']);
    }

    /**
     * Build and update menu structure
     *
     * @param Request $request
     * @return type
     */
    public function build(Request $request)
    {
        $data = json_decode($request->menuList);

        try {
            $this->checkArrayRecursively($data);
        } catch (Exception $ex) {
            return response()->json(['responseCode'=> 500, 'responseMessage' => $ex->getMessage()]);
        }

        return response()->json(['responseCode'=> 200, 'responseMessage' => 'Menu structure has been updated']);
    }

    /**
     * Check is array is recursively
     *
     * @param type $arr
     */
    private function checkArrayRecursively($arr, $parent = null)
    {
        foreach ($arr as $i=>$value) {
            $this->sortMenuItem($value->id, $parent, $i + 1);

            if (isset($value->children)) {
                $this->checkArrayRecursively($value->children, $value->id);
            }
        }
    }

    /**
     * Sort menu item position and parent - child
     *
     * @param type $id
     * @param type $parent
     * @param type $order
     */
    private function sortMenuItem($id, $parent, $order)
    {
        Menu::where('id', $id)->update([
            'parent_id' => $parent,
            'sequence' => $order
        ]);
    }
}
