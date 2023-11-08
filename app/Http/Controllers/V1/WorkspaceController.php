<?php

namespace App\Http\Controllers\V1;

use App\Http\Controllers\Controller;
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
    public function index(Request $request)
    {
        //
        return $this->WorkspaceService->getWorkspaces($request->all());
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(workspace $workspace)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(workspace $workspace)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, workspace $workspace)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(workspace $workspace)
    {
        //
    }
}
