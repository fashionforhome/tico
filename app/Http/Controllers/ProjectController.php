<?php

namespace App\Http\Controllers;

use App\Model\Project;
use App\Model\Ticket;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;

class ProjectController extends Controller
{
	protected $validationRules = [
		'name' => 'required|min:3'
	];


	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function index()
	{
		$projects = Project::all();

		return view('projects.index')->with('projects', $projects);
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
	 * @param Request $request
	 * @return \Illuminate\Http\RedirectResponse|\Illuminate\Routing\Redirector
	 */
	public function store(Request $request)
	{
		// validation
		$this->validate($request, $this->validationRules);
		Project::create($request->all());

		return redirect('projects');
	}

	/**
	 * Display the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function show($id)
	{
		/** @var Project $project */
		$project = Project::findOrFail($id);

		return view('projects.show')->with('project', $project);
	}

	/**
	 * Show the form for editing the specified resource.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function edit($id)
	{
		/** @var Project $project */
		$project = Project::findOrFail($id);

		return view('projects.edit')->with('project', $project);
	}

	/**
	 * Update the specified resource in storage.
	 *
	 * @param  \Illuminate\Http\Request $request
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function update(Request $request, $id)
	{
		$this->validate($request, $this->validationRules);

		/** @var Project $project */
		$project = Project::findOrFail($id);
		$project->update($request->all());

		return redirect('projects');
	}

	/**
	 * Remove the specified resource from storage.
	 *
	 * @param  int $id
	 * @return \Illuminate\Http\Response
	 */
	public function destroy($id)
	{
		/** @var Project $project */
		$project = Project::findOrFail($id);

		/** @var Ticket $ticket */
		foreach ($project->tickets()->get() as $ticket) {
			$ticket->delete();
		}

		$project->delete();

		return redirect('projects');
	}
}
