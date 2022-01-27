<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Str;
use App\Models\User;

class GroupFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        $userByRandom = User::all()->random();

        return [
            'name' => $this->faker->name(),
            'created_by' => $userByRandom
        ];
    }

}
