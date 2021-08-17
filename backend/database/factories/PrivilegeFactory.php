<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Group;
use App\Models\Privilege;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class PrivilegeFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Privilege::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'user_id' => User::inRandomOrder()->first()->id,
            'group_id' => Group::inRandomOrder()->first()->id,
            'privilege' => Arr::random([0, 1, 2]),
        ];
    }
}
