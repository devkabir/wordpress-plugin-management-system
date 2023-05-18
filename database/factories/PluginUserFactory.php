<?php

namespace Database\Factories;

use App\Models\PluginUser;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<PluginUser>
 */
class PluginUserFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $status = rand(1, 3);
        $data = [
            'name' => $this->faker->randomElement([
                'test-plugin-1',
                'test-plugin-2',
                'test-plugin-3',
            ]),
            'version' => $this->faker->randomElement([
                '1.0.0',
                '1.0.2',
                '1.0.4'
            ]),
            'website' => $this->faker->domainName,
            'plugins' => $this->faker->words(5),
            'server' => $this->faker->words(),
            'status' => $status

        ];
        switch ($status) {
            case 1:
                $data['activated_at'] = $this->faker->dateTimeThisYear()->format('Y-m-d');
                break;
            case 2:
                $data['deactivated_at'] = $this->faker->dateTimeThisYear()->format('Y-m-d');
                break;
            default:
                $data['uninstalled_at'] = $this->faker->dateTimeThisYear()->format('Y-m-d');


        }
        return $data;
    }
}
