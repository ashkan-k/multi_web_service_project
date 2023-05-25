<?php

namespace Database\Factories;

use App\Models\TicketCategory;
use App\Models\TicketFrequentlyAskedQuestion;
use App\Models\TicketSubject;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\=Ticket>
 */
class TicketFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
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
