<?php

/*
|--------------------------------------------------------------------------
| Model Factories
|--------------------------------------------------------------------------
|
| Here you may define all of your model factories. Model factories give
| you a convenient way to create models for testing and seeding your
| database. Just tell the factory how a default model should look.
|
*/


$factory->define(App\Model\Project::class, function (Faker\Generator $faker) {
	return [
		'name' => str_random(3)
	];
});

$factory->define(App\Model\Ticket::class, function (Faker\Generator $faker) {
	return [
		'id' => $faker->unique()->numberBetween(1, 200),
		'project_id' => 1
	];
});