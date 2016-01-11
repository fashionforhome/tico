<?php

use Illuminate\Database\Seeder;

class ProjectTableSeeder extends Seeder
{
	/**
	 * Run the database seeds.
	 *
	 * @return void
	 */
	public function run()
	{
		factory(App\Model\Project::class, 3)->create();
	}
}
