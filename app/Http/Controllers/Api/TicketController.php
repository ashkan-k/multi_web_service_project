<?php

namespace App\Http\Controllers\Api;

use App\Http\Traits\Responses;
use App\Http\Traits\Uploader;
use App\Models\Ticket;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    use Responses, Uploader;

    public function index()
    {
        $ticket_categories = Ticket::paginate(env('PAGINATION_NUMBER', 10));
        return $this->SuccessResponse($ticket_categories);
    }

    public function store(Request $request)
    {
        $file = $this->UploadFile($request, 'file', 'ticket_files', auth()->id() . '-' . $request->title);
        $ticket = auth()->user()->tickets()->create(array_merge($request->all(), ['file' => $file]));
        return $this->SuccessResponse(Ticket::find($ticket->id), 201);
    }

    public function show(Ticket $ticket)
    {
        return $this->SuccessResponse($ticket);
    }

    public function update(Request $request, Ticket $ticket)
    {
        $file = $this->UploadFile($request, 'file', 'ticket_files', auth()->id() . '-' . $request->title, $ticket->file);

        $ticket->update(array_merge($request->except(['status', 'user_id']), ['file' => $file]));
        return $this->SuccessResponse(Ticket::find($ticket->id));
    }

    public function destroy(Ticket $ticket)
    {
        $ticket->delete();
        return $this->SuccessResponse("آیتم مورد نظر با موفقیت حذف شد.", 204);
    }
}
