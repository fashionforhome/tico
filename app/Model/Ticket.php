<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;

class Ticket extends Model
{
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	protected $fillable = [
		'id',
		'project_id'
	];

	/**
	 * An Ticket has a project
	 *
	 * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
	 */
	public function project()
	{
		return $this->belongsTo('App\Model\Project');
	}

	/**
	 * @return string
	 */
	public function getTicketName()
	{
		$projectName = $this->project->toArray()['name'];

		return $projectName . '-' . $this->id;
	}
}
