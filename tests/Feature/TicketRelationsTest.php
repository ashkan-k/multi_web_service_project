<?php

use App\Models\TicketCategory;
use App\Models\TicketFrequentlyAskedQuestion;
use App\Models\TicketSubject;
use Tests\MainTest;

class TicketRelationsTest extends MainTest
{
    public function setUp(): void
    {
        parent::setUp();
        auth()->login($this->super_user);

        $this->ticket_category = TicketCategory::create(['title' => 'دسته یک']);
        $this->ticket_subject = TicketSubject::create(['title' => 'موضوع یک']);
        $this->ticket_frequently_asked = TicketFrequentlyAskedQuestion::create(['title' => 'سوال متداول یک']);

        $this->valid_data = [
            'title' => 'test title',
        ];
    }

    private function check_single_response($res_data, $valid_data, $status)
    {
        $this->assertEquals($res_data['title'], $valid_data['title']);
    }

    private function check_list_json_response($res_json)
    {
        foreach ($res_json as $item) {
            $this->assertArrayHasKey('title', $item);
        }
    }

    //

    public function test_ticket_categories_list()
    {
//        $count = TicketCategory::count();
//        $data = $this->valid_data;
//        TicketCategory::create($data);

        $rows = [
            'categories' => TicketCategory::class,
            'frequently_asked_questions' => TicketFrequentlyAskedQuestion::class,
            'subjects' => TicketSubject::class,
        ];

        foreach ($rows as $key => $item) {
            $response = $this->getJson("/api/tickets/{$key}/");
            $res_json = $response->json('data')['data'];

            $count = $item::count();

            $response->assertStatus(200);
            $this->assertEquals($count, count($res_json));
            $this->check_list_json_response($res_json);
        }
    }

//    public function test_ticket_frequently_asked_list()
//    {
//        $response = $this->getJson('/api/tickets/frequently_asked_questions/');
//        $res_json = $response->json('data')['data'];
//
//        $count = TicketFrequentlyAskedQuestion::count();
//
//        $response->assertStatus(200);
//        $this->assertEquals($count, count($res_json));
//        $this->check_list_json_response($res_json);
//    }
//
//    public function test_ticket_frequently_asked_list()
//    {
//        $response = $this->getJson('/api/tickets/frequently_asked_questions/');
//        $res_json = $response->json('data')['data'];
//
//        $count = TicketFrequentlyAskedQuestion::count();
//
//        $response->assertStatus(200);
//        $this->assertEquals($count, count($res_json));
//        $this->check_list_json_response($res_json);
//    }
}
