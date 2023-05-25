<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Requests\TicketSubjectRequest;
use App\Http\Traits\Helpers;
use App\Http\Traits\Responses;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ticket\Entities\TicketSubject;

class TicketSubjectController extends \App\Http\Controllers\Controller
{
    use Helpers, Responses;

    public function index()
    {
        $ticketSubjects = TicketSubject::Search(\request('search'))->paginate(env('PAGINATION_NUMBER', 10));
        return $this->SuccessResponse($ticketSubjects);
    }

    public function store(TicketSubjectRequest $request)
    {
        $ticketCategory = TicketSubject::create($request->all());
        return $this->SuccessResponse(TicketSubject::find($ticketCategory->id), 201);
    }

    public function update(TicketSubjectRequest $request, TicketSubject $subject)
    {
        $subject->update($request->all());
        return $this->SuccessResponse(TicketSubject::find($subject->id));
    }

    public function destroy(TicketSubject $subject)
    {
        $subject->delete();
        return $this->SuccessResponse("آیتم مورد نظر با موفقیت حذف شد.", 204);
    }
}
