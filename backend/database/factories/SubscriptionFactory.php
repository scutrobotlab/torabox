<?php

namespace Database\Factories;

use App\Models\User;
use App\Models\Group;
use App\Models\Subscription;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Arr;

class SubscriptionFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Subscription::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'user_id' => User::inRandomOrder()->first()->id,
            'group_id' => Group::inRandomOrder()->first()->id,
            'end_time' => now()->addDays(Arr::random([1, 10, 20])),
            'description' => $this->faker->text,
        ];
    }
}
