<?php

namespace App\Http\Controllers;
use App\Models\Team;
use App\Models\User;

use App\Models\TeamHasUser;
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
    function teamHasUsers(Request $request) {

        $userIds = $request->input('user_ids');
        $teamId = $request->input('team_id');
    
        // Delete existing team-user relationships for the given team ID
        TeamHasUser::where('team_id', $teamId)->delete();
    
        foreach ($userIds as $userId) {
            // Create a new team-user relationship
            $teamUser = new TeamHasUser;
            $teamUser->team_id = $teamId;
            $teamUser->user_id = $userId;
            $teamUser->save();
        }
    
        return response()->json(['message' => 'Users added to the team successfully']);
    }

    Function getUsersByTeamId($team_id){

        $users = TeamHasUser::where('team_id',$team_id)->get();

        return response()->json(['users' => $users]);
    }

    function getTeamLeadByCompanyId($company_id){
        $users = User::
        where('company_id',$company_id)
        ->where('role',3)
        ->get();

        return response()->json(['Team_Leads' => $users]);
    }
    
}
