<?php

namespace App\Http\Controllers;

use App\Services\Projects\UpdateProjectService;
use App\Services\Projects\StoreProjectService;
use App\Http\Requests\UpdateProjectRequest;
use App\Http\Requests\StoreProjectRequest;
use App\Models\Project;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('projects.index', [
            'projects' => auth()->user()->projects()->latest('updated_at')
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('projects.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreProjectRequest $request)
    {
        $project = app(StoreProjectService::class)
            ->handle($request->validated());

        return redirect()->route('projects.show', $project->slug);
    }


    /**
     * Display the specified resource.
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function show(Project $project)
    {
        $this->authorize('update', $project);
        return view('projects.show', compact('project'));
    }


    /**
     * Show the form for editing the specified resource.
     * @param Project $project
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     * @throws \Illuminate\Auth\Access\AuthorizationException
     */
    public function edit(Project $project)
    {
        $this->authorize('update', $project);

        return view('projects.edit', compact('project'));
    }


    /**
     * Update the specified resource in storage.
     * @param Project $project
     * @param UpdateProjectRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Project $project, UpdateProjectRequest $request)
    {
        $project = app(UpdateProjectService::class)->handle(
            $project,
            $request->validated()
        );

        return redirect()->route('projects.show', $project->slug);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
