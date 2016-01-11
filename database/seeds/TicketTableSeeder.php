<?php

use Illuminate\Database\Seeder;

class TicketTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(App\Model\Ticket::class, 200)->create();
	}
}
