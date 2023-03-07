<?php

namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    function add_team(){
        $team = new Team();
        $team->team_name = \Request::input('team_name');
        $team->members = \Request::input('members');
        $team->projects  = \Request::input('projects');
        $team->save();
        
        return response()->json(['message'=>'Add Team successfully']);
    }

    function updateteam(){
        $id = \Request::input('id');
        $role = Team::where('id',$id)
            ->update([
                'team_name' => \Request::input('team_name'),
                'members' => \Request::input('members'),
                'projects' => \Request::input('projects'),
            ]);

        return response()->json(['Message' => 'team Updated']);
    }

    public function get_teams()
    {
        $team = Team::get();
        return response()->json(['Teams' => $team]);
    }

    function delete_team(){
        $id = \Request::input('id');
        $team = Team::where('id',$id)->delete();

        return response()->json(['message'=>'delete Team successfully']);
    }
}
