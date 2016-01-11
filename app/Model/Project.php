<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
	/**
	 * Indicates if the model should be timestamped.
	 *
	 * @var bool
	 */
	public $timestamps = false;

	protected $fillable = [
		'name'
	];

	public function tickets()
	{
		return $this->hasMany('App\Model\Ticket');
	}
}
