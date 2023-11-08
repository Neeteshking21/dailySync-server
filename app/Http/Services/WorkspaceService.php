<?php

namespace App\Http\Services;

use App\Models\Workspace;
use Illuminate\Support\Facades\Auth;
use App\Traits\RespondsWithHttpStatus;

class WorkspaceService {

    use RespondsWithHttpStatus;

    public function __construct()
    {
        // Peace of Code
    }

    public function getWorkspaces($params) {
        try {
            $user = Auth::User();
            $search = $params['search'] ?? null;
            
            $workspaces = $user->workspaces;
            if($search) {
                $workspaces = $workspaces->where('name', 'like', '%'.$search.'%');
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

}