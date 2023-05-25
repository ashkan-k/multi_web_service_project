<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Requests\TicketAnswerRequest;
use App\Http\Traits\Responses;
use App\Http\Traits\Uploader;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ticket\Entities\Ticket;

class TicketAnswerController extends Controller
{
    use Responses, Uploader;

    public function store(TicketAnswerRequest $request, Ticket $ticket)
    {
        $file = $this->UploadFile($request, 'file' , 'ticket_answers_files', auth()->id() . '-' . $ticket->title);
        $data = [
            'user_id' => auth()->id(),
            'text' => $request->text,
            'file' => $file,
        ];

        $answer = $ticket->answers()->create($data);
        if (auth()->id() == $ticket->user_id){
            $ticket->update(['status' => 'user_response']);
        }else{
            $ticket->update(['status' => 'support_response']);
        }

        return $this->SuccessResponse($answer, 201);
    }
}
