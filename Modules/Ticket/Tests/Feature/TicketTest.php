<?php

namespace Modules\Ticket\Tests\Feature;

use Modules\Ticket\Entities\Ticket;
use Modules\Ticket\Entities\TicketCategory;
use Modules\Ticket\Entities\TicketFrequentlyAskedQuestion;
use Modules\Ticket\Entities\TicketSubject;
use Modules\Ticket\Tests\MainTest;

class TicketTest extends MainTest
{
    public function setUp(): void
    {
        parent::setUp();
        auth()->login($this->super_user);

        $ticket_category = TicketCategory::create(['title' => 'دسته یک']);
        $ticket_subject = TicketSubject::create(['title' => 'موضوع یک']);
        $ticket_frequently_asked = TicketFrequentlyAskedQuestion::create(['title' => 'سوال متداول یک']);

        $this->ticket = Ticket::create([
            'title' => 'test title',
            'text' => 'test description text...',
            'file' => $this->CreateFakeFile(),
            'ticket_category_id' => $ticket_category->id,
            'ticket_frequently_asked_id' => $ticket_frequently_asked->id,
            'ticket_subject_id' => $ticket_subject->id,
            'user_id' => auth()->id(),
        ]);

        $this->valid_data = [
            'title' => 'test title',
            'text' => 'test description text...',
            'file' => $this->CreateFakeFile(),
            'ticket_category_id' => $ticket_category->id,
            'ticket_frequently_asked_id' => $ticket_frequently_asked->id,
            'ticket_subject_id' => $ticket_subject->id,
            'user_id' => auth()->id(),
        ];
    }

    private function check_single_response($res_data, $valid_data, $status)
    {
        $this->assertEquals($res_data['title'], $valid_data['title']);
        $this->assertEquals($res_data['text'], $valid_data['text']);
        $this->assertEquals($res_data['status'], $status);
        $this->assertArrayHasKey('file', $res_data);
        $this->assertEquals($res_data['user_id'], auth()->id());
        $this->assertEquals($res_data['ticket_category_id'], $valid_data['ticket_category_id']);
        $this->assertEquals($res_data['ticket_frequently_asked_id'], $valid_data['ticket_frequently_asked_id']);
        $this->assertEquals($res_data['ticket_subject_id'], $valid_data['ticket_subject_id']);
    }

    private function check_list_json_response($res_json)
    {
        foreach ($res_json as $item) {
            $this->assertArrayHasKey('title', $item);
            $this->assertArrayHasKey('text', $item);
            $this->assertArrayHasKey('user', $item);
            $this->assertArrayHasKey('ticket_category', $item);
            $this->assertArrayHasKey('ticket_frequently_asked', $item);
            $this->assertArrayHasKey('ticket_subject', $item);
            $this->assertArrayHasKey('answers', $item);
            $this->assertArrayHasKey('status', $item);
            $this->assertArrayHasKey('file', $item);
        }
    }

    //

    public function test_my_tickets_list()
    {
        $data = $this->valid_data;
        Ticket::create($data);

        $response = $this->getJson('/api/tickets/');
        $res_json = $response->json('data');

        $response->assertStatus(200);
        $this->assertEquals(count($res_json['data']), auth()->user()->tickets->count());

        $this->check_list_json_response($res_json['data']);
    }

//    public function test_user_tickets_list_type_filter()
//    {
//        foreach (['user' => $this->valid_data['user_id'], 'category' => $this->valid_data['ticket_category_id']] as $key => $value){
//            $response = $this->getJson("/api/tickets/?{$key}=" . $key);
//            $res_json = $response->json('data');
//
//            $response->assertStatus(200);
////            $this->assertTrue($res_json->isEmpty());
//            $this->assertEquals(count($res_json['data']), 1);
//        }
//    }

    public function test_user_ticket_create()
    {
        $before_count = Ticket::count();
        $response = $this->postJson('/api/tickets/', $this->valid_data);
        $after_count = Ticket::count();

        $response->assertStatus(201);
        $this->check_single_response($response->json('data'), $this->valid_data, 'waiting');
        $this->assertEquals($before_count + 1, $after_count);
        $this->assertEquals(auth()->user()->tickets()->count(), 2);
    }

    public function test_user_ticket_update()
    {
        $before_count = Ticket::count();

        $data = $this->valid_data;
        $data['title'] = 'this is new title';

        $response = $this->patchJson("/api/tickets/{$this->ticket->id}/", $data);
        $after_count = Ticket::count();

        $response->assertStatus(200);
        $this->check_single_response($response->json('data'), $data, Ticket::find($this->ticket->id)->status);
        $this->assertEquals($before_count, $after_count);
        $this->assertEquals($response->json('data')['title'], $data['title']);
    }

    public function test_user_ticket_show_detail()
    {
        $response = $this->getJson("/api/tickets/{$this->ticket->id}");

        $ticket_data = $response->json('data')['ticket'];
        $ticket_answers = $response->json('data')['answers'];

        $response->assertStatus(200);
        $this->check_single_response($ticket_data, $this->ticket, Ticket::find($this->ticket->id)->status);
        $this->assertEquals(count($ticket_answers), $this->ticket->answers()->count());
    }

    public function test_user_ticket_delete()
    {
        $ticket = auth()->user()->tickets()->create($this->valid_data);

        $before_count = Ticket::count();
        $response = $this->deleteJson("/api/tickets/{$ticket->id}");
        $after_count = Ticket::count();

        $response->assertStatus(204);
        $this->assertEquals($before_count - 1, $after_count);
    }

    public function test_user_ticket_check_myself_queryset()
    {
        auth()->login($this->simple_user);

        $before_count = Ticket::count();
        $response = $this->deleteJson("/api/tickets/{$this->ticket->id}");
        $after_count = Ticket::count();

        $response->assertStatus(404);
        $this->assertEquals($before_count, $after_count);
    }

    //

    public function test_user_ticket_answer_create()
    {
        auth()->login($this->simple_user);
        $data = $this->valid_data;
        $data['user_id'] = $this->simple_user->id;

        $new_ticket = Ticket::create($data);

        $data = [
            'text' => 'this is a simple ticket answer1',
            'file' => $this->CreateFakeFile(),
        ];

        $before_count = $new_ticket->answers()->count();
        $response = $this->postJson("/api/tickets/answers/store/$new_ticket->id", $data);
        $after_count = $new_ticket->answers()->count();

        $response->assertStatus(201);
        $this->assertEquals($before_count + 1, $after_count);
        $this->assertEquals(auth()->user()->ticket_answeres()->count(), 1);
    }
}
