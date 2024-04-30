<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;
use App\Models\Team;
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

    public function getUsersByTeamLeadId($team_lead_id, $newUserIds)
    {
        // Start a transaction
        DB::beginTransaction();

        try {
            // Get the team
            $team = Team::where('team_lead_id', $team_lead_id)->first();

            // Delete existing team users
            TeamHasUser::where('team_id', $team->id)->delete();

            // Add new team users
            foreach ($newUserIds as $userId) {
                TeamHasUser::create([
                    'team_id' => $team->id,
                    'user_id' => $userId,
                ]);
            }

            DB::commit();

            $teamUsers = TeamHasUser::where('team_id', $team->id)
                ->join('users', 'team_has_users.user_id', '=', 'users.id')
                ->get();

            return response()->json(['team' => $teamUsers]);
        } catch (\Exception $e) {

            DB::rollBack();

            return response()->json(['error' => 'Failed to update team users'], 500);
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

}
