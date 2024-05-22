<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Team;
use App\Models\TeamGroup;
use App\Models\TeamHasUser;
use App\Models\User;
use Illuminate\Http\Request;

class TeamController extends Controller
{
    public function createTeam(Request $request)
    {

        $team = new Team();
        $team->company_id = \Request::input('company_id');
        $team->department_id = \Request::input('department_id');
        $team->team_lead_id = \Request::input('team_lead_id');
        $team->team_name = \Request::input('team_name');
        $team->description = \Request::input('description');
        $team->save();

        return response()->json(['message' => 'Add Team successfully']);
    }

    public function updateTeam($id)
    {

        $role = Team::where('id', $id)
            ->update([
                'team_lead_id' => \Request::input('team_lead_id'),
                'department_id' => \Request::input('department_id'),
                'team_name' => \Request::input('team_name'),
                'company_id' => \Request::input('company_id'),
                'description' => \Request::input('description'),
            ]);

        return response()->json(['Message' => 'team Updated']);
    }

    public function getTeams()
    {
        $team = Team::get();

        return response()->json(['Teams' => $team]);
    }

    public function deleteTeam($id)
    {

        $team = Team::where('id', $id)->delete();

        return response()->json(['message' => 'delete Team successfully']);
    }

    public function getTeamById($team_id)
    {
        $team = Team::
            where('id', $team_id)->get();

        return response()->json(['Team' => $team]);
    }
    public function teamHasUsers(Request $request)
    {

        $userIds = $request->input('user_ids');
        $teamId = $request->input('team_id');

        TeamHasUser::where('team_id', $teamId)->delete();

        foreach ($userIds as $userId) {
            $teamUser = new TeamHasUser;
            $teamUser->team_id = $teamId;
            $teamUser->user_id = $userId;
            $teamUser->save();
        }

        return response()->json(['message' => 'Users added to the team successfully']);
    }

    public function getUsersByTeamLeadId($team_lead_id)
    {
        try {

            $team = Team::where('team_lead_id', $team_lead_id)->first();

            if (!$team) {
                return response()->json(['error' => 'Team lead not found'], 404);
            }

            $teamUsers = TeamHasUser::where('team_id', $team->id)
                ->join('users', 'team_has_users.user_id', '=', 'users.id')
                ->get();

            return response()->json(['team' => $teamUsers]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch team users'], 500);
        }
    }

    public function getTeamLeadByCompanyId($company_id)
    {
        $users = User::
            where('company_id', $company_id)
            ->where('role', 7)
            ->get();

        return response()->json(['Team_Leads' => $users]);
    }

    public function getTeamsByDepartmentId($department_id)
    {
        $team = Team::join('departments', 'teams.department_id', '=', 'departments.id')
            ->where('departments.id', $department_id)
            ->select('teams.*', 'departments.*')
            ->get();

        return response()->json(['team' => $team]);
    }

    public function getPeojectsByTeamLeadId($team_lead_id)
    {
        $Projects = Project::
            where('project_manager', $team_lead_id)
            ->get();

        return response()->json(['Projects' => $Projects]);
    }
    // get all team_leads_by_company_id

    public function getTeamLeadsByCompanyId($company_id)
    {
        $team_leads = User::
            where('company_id', $company_id)
            ->where('role', 7)
            ->get();

        return response()->json(['team_leads' => $team_leads]);
    }

    function getTeamsByCompanyId($company_id){
        $teams = Team:: where('company_id', $company_id)
            ->count();

        return response()->json(['teams' => $teams]);
    }

    function createGroup(Request $request){

        $group = new TeamGroup();
        $group->team_id = \Request::input('team_id');
        $group->group_lead_id = \Request::input('group_lead_id');
        $group->group_name = \Request::input('group_name');
        $group->description = \Request::input('description');
        $group->is_active = 1;
        $group->save();

        return response()->json(['message' => 'Add Group Successfully']);
    }
}
