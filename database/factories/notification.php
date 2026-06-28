<?php

namespace Database\Factories;

use App\Models\UserProjection;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<UserProjection>
 */
class notification extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'memberCardUuid' => fake()->unique()->uuid(),
            'email' => fake()->unique()->safeEmail(),
        ];
    }
}
