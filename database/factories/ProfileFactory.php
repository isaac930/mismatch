<?php

namespace Database\Factories;

use App\Models\Profile;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProfileFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Profile::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'name' =>$this->faker->name(),
            'email' => $this->faker->unique()->safeEmail(),
            'contact' => rand(0, 10),
            'age' => rand(0, 100),
            'location' => $this->faker->word(),
            'place_of_birth' => today(),
            'occupation' => $this->faker->word(),
            'likes' => $this->faker->paragraph(),
            'dislikes' => $this->faker->paragraph(),
            'gender' => $this->faker->word(),
            'searching_status' => $this->faker->paragraph(),
            'image_path' => $this->faker->word(),
            
        ];
    }
}
