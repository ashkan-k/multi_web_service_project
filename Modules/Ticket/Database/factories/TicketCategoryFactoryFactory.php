<?php

namespace Modules\Ticket\Database\factories;

use Illuminate\Database\Eloquent\Factories\Factory;

class TicketCategoryFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Ticket\Entities\TicketCategoryFactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => fake()->title(),
        ];
    }
}

