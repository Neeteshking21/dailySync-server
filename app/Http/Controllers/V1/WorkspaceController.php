<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\V1\WorkspaceCreateRequest;
use App\Http\Requests\V1\WorkspaceDestroyRequest;
use App\Http\Requests\V1\WorkspaceIndexRequest;
use App\Http\Requests\V1\WorkspaceUpdateRequest;
use App\Http\Services\WorkspaceService;
use App\Models\workspace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WorkspaceController extends Controller
{
    private $WorkspaceService;
    public function __construct(WorkspaceService $WorkspaceService)
    {
        $this->WorkspaceService = $WorkspaceService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(WorkspaceIndexRequest $request)
    {
        //get
        $params = [
            '_user' => Auth::User(),
            ...$request->all()
        ];
        return $this->WorkspaceService->getWorkspaces($params);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(WorkspaceCreateRequest $request)
    {
        //post
        $params = [
            '_user' => Auth::User(),
            ...$request->all()
        ];
        return $this->WorkspaceService->createWorkspace($params);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(WorkspaceUpdateRequest $request)
    {
        // put/patch
        $params = [
            '_user' => Auth::User(),
            ...$request->all()
        ];
        return $this->WorkspaceService->updateWorkspace($params);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(WorkspaceDestroyRequest $request)
    {
        //DELETE
        $params = [
            '_user' => Auth::User(),
            ...$request->all()
        ];
        return $this->WorkspaceService->softDeleteWorkspaces($params);
    }
}
