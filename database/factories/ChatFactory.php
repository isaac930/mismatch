<?php

namespace Database\Factories;

use App\Models\Chat;
use Illuminate\Database\Eloquent\Factories\Factory;

class ChatFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Chat::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'date' => today(),
            'name' => $this->faker->name(),
            'contact' => rand(0,10),
            'email' => $this->faker->unique()->safeEmail(),
            'chatment_email' => $this->faker->unique()->safeEmail(),
            'chatment_name' => $this->faker->name(),
            'chatment_contact' => rand(0,10),
            'post' => $this->faker->sentence(),
        ];
    }
}
