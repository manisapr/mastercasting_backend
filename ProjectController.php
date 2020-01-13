<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProjectController extends Controller
{
    public function __construct(){
        DB::enableQueryLog();
    }

    
    
    public function get_all_projects(Request $request){
        $user_id = $request->user_id;

        $projects = $this->get_projects($user_id, 'live')->count();

        return response()->json($projects);
    }


    public function get_projects($user_id, $type = 'all'){

        $user = DB::table('user')->join('designation', 'user.designation_id', '=', 'designation.designation_id')->selectRaw('id, dynamic_id, company_id, user.designation_id')->where(['id' => $user_id])->first();

        if(count($user) == 0)
            return response()->json(['error' => 'Something went wrong']);

        $projects = [];
        
        if($user->designation_id == 5){
            $projects = DB::table('project')
            ->when($type == 'completed', function($query){
                return $query->where(['type' => 'completed']);
            })
            ->when($type == 'live', function($query){
                return $query->where(['type' => 'live']);
            })
            ->when($type == 'cancelled', function($query){
                return $query->where(['type' => 'cancelled']);
            })
            ->when($type == 'proposal', function($query){
                return $query->where(['type' => 'proposal']);
            })
            ->where(['assign_by' => $user_id])
            ->orWhere(['asign_user' => $user_id])
            ->orWhereRaw("FIND_IN_SET('$user_id', `assignee`)")
            ->join('project_details', 'project.project_id', '=', 'project_details.project_id')
            ->orderBy('created_at', 'desc')
            ->get();
        } else if($user->designation_id == 7){

            $associates = DB::table('user')->where(['company_id' => $user->company_id])->pluck('id')->toArray();
            // echo $type;die;
            $projects = DB::table('project')
            ->when($type == 'completed', function($query){
                return $query->where(['type' => 'completed']);
            })
            ->when($type == 'live', function($query){
                return $query->where(['type' => 'live']);
            })
            ->when($type == 'cancelled', function($query){
                return $query->where(['type' => 'cancelled']);
            })
            ->when($type == 'proposal', function($query){
                return $query->where(['type' => 'proposal']);
            })
            ->whereIn('assign_by', $associates)
            ->orWhereIn('asign_user', $associates)
            ->join('project_details', 'project.project_id', '=', 'project_details.project_id')
            ->orderBy('created_at', 'desc')
            ->get();

        } else {
            if($user->designation_id == 9){
                $projects = DB::table('project')
                ->when($type == 'completed', function($query){
                    return $query->where(['type' => 'completed']);
                })
                ->when($type == 'live', function($query){
                    return $query->where(['type' => 'live']);
                })
                ->when($type == 'cancelled', function($query){
                    return $query->where(['type' => 'cancelled']);
                })
                ->when($type == 'proposal', function($query){
                    return $query->where(['type' => 'proposal']);
                })
                ->where(['assign_by' => $user_id])
                ->orWhere(['asign_user' => $user_id])
                ->orWhereRaw("FIND_IN_SET('$user_id', `assignee`)")
                ->join('project_details', 'project.project_id', '=', 'project_details.project_id')
                ->orderBy('created_at', 'desc')
                ->get();
            } else {
                $projects = DB::table('project')
                ->when($type == 'completed', function($query){
                    return $query->where(['type' => 'completed']);
                })
                ->when($type == 'live', function($query){
                    return $query->where(['type' => 'live']);
                })
                ->when($type == 'cancelled', function($query){
                    return $query->where(['type' => 'cancelled']);
                })
                ->when($type == 'proposal', function($query){
                    return $query->where(['type' => 'proposal']);
                })
                ->join('project_details', 'project.project_id', '=', 'project_details.project_id')
                ->orderBy('created_at', 'desc')
                ->get();
            }
        }

        dd(
            DB::getQueryLog()
        );


        return $projects;
    }

}
