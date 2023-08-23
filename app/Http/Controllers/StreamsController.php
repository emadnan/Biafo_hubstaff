<?php

namespace App\Http\Controllers;
use App\Models\Streams;
use App\Models\StreamsHasUser;
use Illuminate\Http\Request;
use DB;

class StreamsController extends Controller
{
    function addStreams()  {

        $stream = new Streams();
        $stream->company_id = \Request::input('company_id');
        $stream->stream_name = \Request::input('stream_name');
        $stream->project_id = \Request::input('project_id');
        $stream->start_time = \Request::input('start_time');
        $stream->end_time = \Request::input('end_time');


        $stream->save();
        return response()->json(['message'=>'Add stream successfully']);

    }

    function updateStream() {

        $id = \Request::input('id');
        $stream = Streams::where('id',$id)
        ->update([
            'company_id' => \Request::input('company_id'),
            'stream_name' => \Request::input('stream_name'),
            'project_id' => \Request::input('project_id'),
            'start_time' => \Request::input('start_time'),
            'end_time' => \Request::input('end_time')
        ]);

        return response()->json(['Message' => 'stream Updated']);
    }

    function deleteStream()    {

        $id = \Request::input('id');
        $stream = Streams::where('id',$id)->delete();

        return response()->json(['message'=>'delete stream successfully']);
    }

    public function getStreamByCompanyId($id)  {

        $stream = Streams::where('company_id',$id)
        ->with('projectDetails')
        ->get();
        return response()->json(['streams' => $stream]);
    }

    public function getStreamById($id)  {

        $stream = Streams::where('id',$id)
        ->with('projectDetails')
        ->get();
        return response()->json(['streams' => $stream]);
    }

    public function getStreams()
    {
        $streams = Streams::orderBy('stream_name', 'asc')
        ->with('projectDetails')
        ->get();
        return response()->json(['Streams' => $streams]);
    }

    public function assignStreamsToUsers(Request $request)
        {
            $stream_id = $request->input('stream_id');
            $user_ids = $request->input('user_ids');

            // Validation
            if (!$stream_id || empty($user_ids)) {
                return response()->json(['message' => 'Invalid input data'], 400);
            }

            if (!is_array($user_ids)) {
                $user_ids = explode(',', $user_ids);
            }

            // Delete existing assignments
            StreamsHasUser::where('stream_id', $stream_id)
                ->delete();

            $maxAssignments = 3;

            DB::beginTransaction(); // Start a database transaction

            try {
                foreach ($user_ids as $user_id) {
                    // Calculate the current number of streams assigned to this user
                    $currentAssignments = StreamsHasUser::where('user_id', $user_id)->count();

                    // Check if adding this assignment would exceed the limit
                    if ($currentAssignments < $maxAssignments) {
                        // Create a new assignment
                        $assign = new StreamsHasUser;
                        $assign->stream_id = $stream_id;
                        $assign->user_id = $user_id;
                        $assign->save();
                    } else {
                        DB::rollBack(); // Roll back the transaction
                        return response()->json(['message' => 'You have reached the maximum limit of assigned streams'], 422);
                    }
                }

                DB::commit(); // Commit the transaction

                return response()->json(['message' => 'Streams assigned to users successfully']);
            } catch (\Exception $e) {
                DB::rollBack(); // Roll back the transaction on error
                return response()->json(['message' => 'An error occurred while processing your request'], 500);
            }
        }

    

    public function updateAssignedStreamType(Request $request) {

        $userId = \Request::input('user_id');
        $streamId = \Request::input('stream_id');
        $assign = StreamsHasUser::where('user_id', $userId)
            ->first();
            
        if (!$assign) {
            return response()->json(['message' => 'Assignment not found'], 404);
        }
    
        $assigning_type_id = $request->input('assigning_type_id');
        
        // Calculate the sum of assigning_type_id for the user and stream excluding the current record
        $totalAssigningTypeId = StreamsHasUser::where('user_id', $userId)
            ->where('stream_id', $streamId)
            ->where('id', '<>', $assign->id)
            ->sum('assigning_type_id');
    
        // Check if adding this assigning_type_id exceeds the limit
        if (($totalAssigningTypeId + $assigning_type_id) < 3) {
            // Check specific rules based on assigning_type value
            
            if ($assigning_type_id <= 3) {
                $allowedCount = 3; // Allow adding assigning_type_id when assigning_type is 1 or 2
                if ($totalAssigningTypeId + $assigning_type_id <= $allowedCount) {
                    // Update the assigning_type_id value and save changes
                    $assign->assigning_type_id = $assigning_type_id;
                    $assign->save();
                    return response()->json(['message' => 'Assigning type updated successfully']);
                } else {
                    return response()->json(['message' => 'Your limit of assigning is about to end'], 422);
                }
            } else {
                return response()->json(['message' => 'Cannot assign streams to users'], 422);
            }
        } else {
            return response()->json(['message' => 'Your limit of assigning is about to end'], 422);
        }
    }
    
    

    function getUsersByStreamsId($streamId){
        $stream = StreamsHasUser::
        where('stream_id',$streamId)
        ->with('userDetails')
        ->with('assignTypeDetails')
        ->get();

        return response()->json(['Streams' => $stream]);
    }
    
    function getAssigningStreamsUsers(){

        $stream = StreamsHasUser::get();

        return response()->json(['Streams' => $stream]);
    }

    function getAssignedTypeId($id) {

        $assignedType = StreamsHasUser::where('id', $id)
            ->first(); 
    
        return response()->json(['Assigned_Type_Id' => $assignedType]);
    }
}
