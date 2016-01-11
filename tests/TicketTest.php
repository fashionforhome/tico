<?php

use App\Model\Project;
use App\Model\Ticket;
use Illuminate\Foundation\Testing\WithoutMiddleware;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class TicketTest extends TestCase
{
	/**
	 * A basic test example.
	 *
	 * @return void
	 */
	public function testBuildTicketName()
	{
		$ticket        = new Ticket();
		$project       = new Project();
		$project->name = 'test';

		$ticket->id      = 1;
		$ticket->project = $project;

		$this->assertEquals('test-1', $ticket->getTicketName());
	}
}
