<?php

namespace App\Model;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Config;
use App\Model\Project;
use Psy\Exception\RuntimeException;

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

    /**
     * Sets id and project_id by a given ticket name. Throws an exception if the project cannot be found in the database.
     *
     * @param string $ticketName The name of the ticket, e.g. PROJECT-225
     * @return $this
     * @throws RuntimeException
     */
	public function setTicketName($ticketName)
    {
        if (is_string($ticketName) === false) {
            return $this;
        }

        $ticket = explode('-', $ticketName);
        if (count($ticket) === 2 && $ticket[0] !== '' && $ticket[1] !== '') {
            $this->project_id = $this->getProjectIdByName($ticket[0]);
            $this->id = $ticket[1];
        }

        return $this;
    }

    /**
     * Returns the id of a project given by name.
     * Throws an exception if no project was found.
     *
     * @param string $name The name of the project
     * @return mixed
     * @throws RuntimeException
     */
    protected function getProjectIdByName($name)
    {
        $collection = Project::where('name', $name)->get();
        if ($collection->count() === 0) {
            throw new RuntimeException('No project found for name: ' . $name);
        }
        return $collection->shift()->id;
    }
}
