<?php

namespace App\Http\Services;

use App\Models\Workspace;
use App\Models\WorkspaceUser;
use Illuminate\Support\Facades\Auth;
use App\Traits\RespondsWithHttpStatus;
use GuzzleHttp\Psr7\Response;
use Illuminate\Support\Facades\DB;

class WorkspaceService {

    use RespondsWithHttpStatus;

    public function __construct()
    {
        // Peace of Code
    }

    /**
     * @param Array $params
     * @return Response
    */
    public function getWorkspaces($params) {
        try {
            $user = Auth::User();
            $search = $params['search'] ?? null;

            $userWithRelationships = $user->load('_workspaces'); // Eager load relationships for the authenticated user
            $workspaces = $userWithRelationships->_workspaces;
            if ($search) {
                $workspaces = $workspaces->filter(function ($workspace) use ($search) {
                    return is_numeric(strpos(
                        strtolower(implode(',', [$workspace->id, $workspace->name])),
                        $search
                    ));
                });
            }
            $result = $workspaces->toArray();

            return $this->success(
                "Workspaces fetched successfully",
                $result
            );
        }catch(\Exception $e) {
            return $this->failure($e->getMessage(), [], 501);
        }
    }

    /**
     * @param Array $params
     * @return Array
     * @todo  implement create method
     * 
    */
    public function createWorkspace($params) {
        try{
            $user = $params['_user'];
            $name = $params['name'];
            DB::beginTransaction();
            $Workspace = new Workspace();
            $Workspace->name = $name;
            $Workspace->user_id = $user->id;
            $is_saved = $Workspace->save();
            if(!$is_saved) {
                throw new \Exception("Failed to save workspace, Please try again!");
            }
            $WorkspaceUser = new WorkspaceUser();
            $WorkspaceUser->user_id = $user->id;
            $WorkspaceUser->workspace_id = $Workspace->id;
            $WorkspaceUser->subordinates = json_encode([$user->id]);                
            $is_saved = $WorkspaceUser->save();
            if(!$is_saved) {
                throw new \Exception("Failed to save workspace, Please try again!");
            }
            DB::commit();
            return $this->success(
                "Workspace created successfully"
            );
        }catch(\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), [], 501);
        }
    }

    /**
    * @param Array $params
    * @return Array
    * @todo  implement update method
    * 
    */
    public function updateWorkspace($params) 
    {
        try {
            $user = $params['_user'];
            $workspace_id = $params['workspace_id'];
            $workspace = $params['workspace'] ?? [];
            $workspace_user = $params['workspace_user'] ?? [];
            DB::beginTransaction();
            if(!empty($workspace)) {
                $update = array();
                if(isset($workspace['name'])) {
                    $update['name'] = $workspace['name'];
                }
                $is_updated = Workspace::where([['id', $workspace_id], ['user_id', $user->id]])->update($update);
                if(!$is_updated) {
                    throw new \Exception("Failed to update workspace, Please try again");
                }
            }

            if(!empty($workspace_user)) {
                foreach($workspace_user as $workspace) {
                    $update = array();
                    if(isset($workspace['subordinates'])) {
                        $update['subordinates'] = json_encode(array_map('intval', $workspace['subordinates']));
                    }
                    if(isset($workspace['role'])) {
                        $update['role'] = json_encode(array_map('intval', $workspace['role']));
                    }
                    if(isset($workspace['access_type'])) {
                        $update['access_type'] = $workspace['access_type'];
                    }

                    if(!empty($update)) {
                        $is_updated = WorkspaceUser::where('workspace_id', $workspace_id)->update($update);
                        if(!$is_updated) {
                            throw new \Exception("Failed to update workspace, Please try again");
                        }
                    }
                }
            }
            DB::commit();
            return $this->success(
                "Workspace updated successfully"
            );
        }catch(\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), [], 501);
        }
    }

    /**
    * @param Array $params
    * @return Response
    * @todo  implement soft delete method
    * 
    */
    public function softDeleteWorkspaces($params)
    {
        try{
            $user = $params['_user'];
            $workspaces = $params['workspaces'] ?? [];

            DB::beginTransaction();
            if(!empty($workspaces)){
                $is_deleted = Workspace::whereIn('id', $workspaces)->delete();
                if(!$is_deleted){
                    throw new \Exception("Failed to delete workspace, Please try again");
                }
                $is_deleted = WorkspaceUser::whereIn('workspace_id', $workspaces)->delete();
                if(!$is_deleted){
                    throw new \Exception("Failed to delete workspace, Please try again");
                }
            }
            DB::commit();
            return $this->success(
                "Workspaces deleted successfully"
            );
        }catch(\Exception $e) {
            DB::rollBack();
            return $this->failure($e->getMessage(), [], 501);
        }
    }

}