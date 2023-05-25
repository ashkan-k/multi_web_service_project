<?php

namespace Modules\Ticket\Database\factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Modules\Ticket\Entities\TicketCategory;
use Modules\Ticket\Entities\TicketFrequentlyAskedQuestion;
use Modules\Ticket\Entities\TicketSubject;

class TicketFactoryFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = \Modules\Ticket\Entities\TicketFactory::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'status' => fake()->randomElement(['waiting', 'pending', 'support_response', 'user_response', 'done', 'close']),
            'title' => fake()->title(),
            'text' => fake()->text(),
            'file' => fake()->image(),
            'user_id' => User::factory(),
            'ticket_category_id' => TicketCategory::factory(),
            'ticket_frequently_asked_id' => TicketFrequentlyAskedQuestion::factory(),
            'ticket_subject_id' => TicketSubject::factory(),
        ];
    }
}

