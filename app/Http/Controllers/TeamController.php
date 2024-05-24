<?php

namespace App\Http\Controllers;

use App\Models\GroupHasUser;
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

        $is_group = \Request::input('is_group');

        if ($is_group == 1) {
            $teamGroup = new TeamGroup();
            $teamGroup->team_id = $team->id;
            $teamGroup->group_lead_id = \Request::input('group_lead_id');
            $teamGroup->group_name = \Request::input('group_name');
            $teamGroup->description = \Request::input('description');
            $teamGroup->is_active = 1;
            $teamGroup->save();

            return response()->json(['message' => 'Add Team and Group successfully']);
        }

        return response()->json(['message' => 'Add Team successfully']);
    }

    public function updateTeam($id)
    {

        $is_group = \Request::input('is_group');
        $role = Team::where('id', $id)
            ->update([
                'team_lead_id' => \Request::input('team_lead_id'),
                'department_id' => \Request::input('department_id'),
                'team_name' => \Request::input('team_name'),
                'company_id' => \Request::input('company_id'),
                'description' => \Request::input('description'),
            ]);

        if ($is_group == 1) {

            $teamGroup = TeamGroup::where('team_id', $id)
                ->update([
                    'group_lead_id' => \Request::input('group_lead_id'),
                    'group_name' => \Request::input('group_name'),
                    'description' => \Request::input('description'),
                ]);
        }

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
            $teams = Team::where('team_lead_id', $team_lead_id)->get();
    
            if ($teams->isEmpty()) {
                return response()->json(['error' => 'Team lead not found'], 404);
            }
    
            $allTeamUsers = collect();
    
            foreach ($teams as $team) {
                $teamUsers = TeamHasUser::where('team_id', $team->id)
                    ->join('users', 'team_has_users.user_id', '=', 'users.id')
                    ->select('users.*') // Select only user columns
                    ->get();
    
                $allTeamUsers = $allTeamUsers->merge($teamUsers);
            }
    
            // Ensure each user appears only once in the list
            $uniqueUsers = $allTeamUsers->unique('id');
    
            return response()->json(['team' => $uniqueUsers->values()]);
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

    public function getTeamsByCompanyId($company_id)
    {
        $teams = Team::where('company_id', $company_id)
            ->count();

        return response()->json(['teams' => $teams]);
    }

    public function createGroup(Request $request)
    {

        $group = new TeamGroup();
        $group->team_id = \Request::input('team_id');
        $group->group_lead_id = \Request::input('group_lead_id');
        $group->group_name = \Request::input('group_name');
        $group->description = \Request::input('description');
        $group->is_active = 1;
        $group->save();

        return response()->json(['message' => 'Add Group Successfully']);
    }

    public function updateGroup($id)
    {

        $update = TeamGroup::where('id', $id)
            ->update([
                'team_id' => \Request::input('team_id'),
                'group_lead_id' => \Request::input('group_lead_id'),
                'group_name' => \Request::input('group_name'),
                'description' => \Request::input('description'),
            ]);

        return response()->json(['Message' => 'Group Updated']);

    }

    public function deleteGroup($id)
    {
        $delete = TeamGroup::where('id', $id)->delete();

        return response()->json(['message' => 'Delete Group Successfully']);

    }

    public function getGroupsByTeamId($team_id)
    {
        try {

            $groups = TeamGroup::where('team_id', $team_id)->get();

            if ($groups->isEmpty()) {
                return response()->json(['error' => 'No groups found for this team'], 404);
            }

            $groupsWithUsers = [];

            foreach ($groups as $group) {
                $groupUsers = GroupHasUser::where('group_id', $group->id)
                    ->join('users', 'group_has_users.user_id', '=', 'users.id')
                    ->select('users.*') // Select only user columns
                    ->get();
                $groupsWithUsers[] = [
                    'group' => $group,
                    'users' => $groupUsers,
                ];
            }

            return response()->json(['groups' => $groupsWithUsers]);
        } catch (\Exception $e) {
            return response()->json(['error' => 'Failed to fetch groups and users'], 500);
        }
    }

    public function getGroupById($group_id)
    {
        $group = TeamGroup::where('id', $group_id)
            ->get();

        return response()->json(['group' => $group]);

    }

    public function groupHasUsers(Request $request)
    {
        $userIds = $request->input('user_ids');
        $group_id = $request->input('group_id');

        GroupHasUser::where('group_id', $group_id)->delete();

        foreach ($userIds as $userId) {
            $teamUser = new GroupHasUser;
            $teamUser->group_id = $group_id;
            $teamUser->user_id = $userId;
            $teamUser->save();
        }

        return response()->json(['message' => 'Users added to the Group Successfully']);
    }

}