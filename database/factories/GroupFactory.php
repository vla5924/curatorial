<?php

namespace Database\Factories;

use App\Models\Group;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;

class GroupFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Group::class;

    protected static $i = 0;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        static::$i++;

        return [
            'name' => $this->faker->title(),
            'vk_id' => rand(100000, 999999),
            'alias' => 'group' . static::$i,
            'vk_confirmation_token' => Str::random(6),
            'timetable_url' => 'https://docs.google.com/spreadsheets/d/' . Str::random(45),
        ];
    }
}
