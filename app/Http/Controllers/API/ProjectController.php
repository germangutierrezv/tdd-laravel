<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\API\BaseAPIController;
use App\Http\Requests\CreateProjectRequest;
use App\Http\Requests\UpdateProjectRequest;
use Illuminate\Http\Request;

class ProjectController extends BaseAPIController
{
  /**
   * Display a listing of the resource.
   *
   * @return \Illuminate\Http\Response
   */
  public function index()
  {
    return $this->me()->projects()->paginate();
  }

  /**
   * Store a newly created resource in storage.
   *
   * @param  \App\Http\Requests\CreateProjectRequest  $request
   * @return \Illuminate\Http\Response
   */
  public function store(CreateProjectRequest $request)
  {
    $data = $request->validated();

    $project = $this->me()->projects()->create($data);

    return response()->json($project->toArray(), 201);
  }

  /**
   * Display the specified resource.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function show($id)
  {
    return $this->me()->projects()
      ->with('tasks')
      ->findOrFail($id);
  }

  /**
   * Update the specified resource in storage.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function update(UpdateProjectRequest $request, $id)
  {
    $project = $this->me()->projects()->findOrFail($id);

    $project->update($request->except('archived_at'));

    return $project;
  }

  /**
   * Remove the specified resource from storage.
   *
   * @param  int  $id
   * @return \Illuminate\Http\Response
   */
  public function destroy($id)
  {
    $this->me()->projects()->delete($id);

    return response('', 204);
  }
}
