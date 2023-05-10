<?php

namespace App\Http\Controllers;
use App\Models\Team;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    function add_team(Request $request){
        $team = new Team();
        $team->team_name = \Request::input('team_name');
        $team->team_company_id = \Request::input('team_company_id');
        $team->description  = \Request::input('description');
        $team->save();
        return response()->json(['message'=>'Add Team successfully']);
    }

    function updateteam(){
        $id = \Request::input('id');
        $role = Team::where('id',$id)
            ->update([
                'team_name' => \Request::input('team_name'),
                'team_company_id' => \Request::input('team_company_id'),
                'description' => \Request::input('description'),
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

    public function getTeamById($team_id)
    {
        $team = Team::
        where('id',$team_id)->get();
        return response()->json(['Team' => $team]);
    }
}
