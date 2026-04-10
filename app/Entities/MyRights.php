<?php

namespace App\Entities;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class MyRights
{
    /**
     * Create a new class instance.
     */
    protected $user;

    public function __construct()
    {
        //
        $this->user = Auth::user();

        // dd($user->user_group);
    }

    public function getUserGroup()
    {
        return (!is_null($this->user)) ? $this->user->user_group : null;
    }

    public function buildRights()
    {
        $data = DB::table('menu_main')
                ->join('menu_sub','menu_main.id','=','menu_sub.main_id') 
                ->join('user_groups_rights','menu_sub.id','=','user_groups_rights.menu_sub_id')
                ->where('user_groups_rights.group_id','=',$this->getUserGroup())
                ->select(DB::raw("menu_main.id,menu_main.description as label,menu_main.href as url,menu_main.icon,isActive"))
                ->distinct()
                ->get();

        foreach($data as $main)
        {
            $sub = DB::table('menu_main')
                ->join('menu_sub','menu_main.id','=','menu_sub.main_id') 
                ->join('user_groups_rights','menu_sub.id','=','user_groups_rights.menu_sub_id')
                ->where('user_groups_rights.group_id','=',$this->getUserGroup())
                ->where('menu_sub.main_id','=',$main->id)
                ->select(DB::raw("menu_sub.id,menu_sub.description as label, menu_sub.href as url, menu_sub.icon"))
                ->get(); 

            $main->items = $sub;
        }

        return $data;
    }

}
