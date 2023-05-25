<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TicketSubjectRequest;
use App\Http\Traits\Helpers;
use App\Http\Traits\Responses;
use App\Models\TicketSubject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketSubjectController extends Controller
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
