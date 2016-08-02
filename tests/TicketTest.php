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

    /**
     * Tests that ticket data is set correctly.
     *
     * @covers \App\Model\Ticket::setTicketName
     */
	public function testSetTicketNameHappy()
    {
        $ticketName = 'PROJECT-225';
        $mockBuilder = $this->getMockBuilder('\App\Model\Ticket');
        $mockBuilder->setMethods(['getProjectIdByName']);
        $ticket = $mockBuilder->getMock();
        $ticket->expects($this->once())
            ->method('getProjectIdByName')
            ->with('PROJECT')
            ->will($this->returnValue('123'));
        $this->assertInstanceOf(
            '\App\Model\Ticket',
            $ticket->setTicketName($ticketName),
            'Method setTicketName() must support fluent interfaces.'
        );
        $this->assertSame('123', $ticket->project_id, 'project_id is not set.');
        $this->assertSame('225', $ticket->id, 'id is not set.');
    }

    /**
     * Return TicketNames for unhappy test case.
     *
     * @return array
     */
    public function dataProviderTicketNameUnhappy()
    {
        return [
            [''],
            ['123'],
            ['PROJECT'],
            ['-'],
            [123],
            [123.456],
            [true]
        ];
    }

    /**
     * Tests that ticket data is not set for invalid ticket names.
     *
     * @param mixed $ticketName
     *
     * @dataProvider dataProviderTicketNameUnhappy
     * @covers \App\Model\Ticket::setTicketName
     */
    public function testSetTicketNameUnhappy($ticketName)
    {
        $ticket = new Ticket();
        $ticket->setTicketName($ticketName);
        $this->assertNull($ticket->id, 'ID should not be set by invalid ticket names.');
        $this->assertNull($ticket->project_id, 'project_id should not be set by invalid ticket names.');
    }

    /**
     * @covers \App\Model\Ticket::setTicketName
     * @covers \App\Model\Ticket::getProjectIdByName
     */
    public function testSetTicketNameException()
    {
        $ticket = new Ticket();
        $this->setExpectedException('Psy\Exception\RuntimeException', 'No project found for name: PROJECT');
        $ticket->setTicketName('PROJECT-NOTEXISTING');
    }
}
