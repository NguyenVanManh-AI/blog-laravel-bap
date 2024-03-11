<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    protected $model = User::class;

    public function definition()
    {
        return [
            'name' => $this->faker->name,
            'email' => $this->faker->unique()->safeEmail,
            'password' => Hash::make('password'),
            'google_id' => $this->faker->randomNumber(9),
            'github_id' => $this->faker->randomNumber(8),
            'username' => $this->faker->userName,
            'created_at' => now(),
            'updated_at' => now(),
            'email_verified_at' => now(),
            'avatar' => 'storage/Blog/image/avatars/' . $this->faker->image('public/storage/Blog/image/avatars', 200, 200, null, false),
            'gender' => $this->faker->numberBetween(0, 1),
            // 'password' => Hash::make(Str::random(10)),
        ];
    }

    /**
     * Indicate that the model's email address should be unverified.
     *
     * @return static
     */
    public function unverified()
    {
        return $this->state(function (array $attributes) {
            return [
                'email_verified_at' => null,
            ];
        });
    }
}
