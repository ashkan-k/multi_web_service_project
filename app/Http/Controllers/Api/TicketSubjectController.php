<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TicketSubjectRequest;
use App\Http\Traits\Helpers;
use App\Models\TicketSubject;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketSubjectController extends Controller
{
    use Helpers;

    public function index()
    {
        $ticketSubjects = TicketSubject::paginate(env('PAGINATION_NUMBER', 10));
        return $this->SuccessResponse($ticketSubjects);
    }

    public function store(TicketSubjectRequest $request)
    {
        $ticketCategory = TicketSubject::create($request->all());
        return $this->SuccessResponse(TicketSubject::find($ticketCategory->id), 201);
    }

    public function update(TicketSubjectRequest $request, TicketSubject $ticketSubject)
    {
        $ticketSubject->update($request->all());
        return $this->SuccessResponse(TicketSubject::find($ticketSubject->id));
    }

    public function destroy(TicketSubject $ticketSubject)
    {
        $ticketSubject->delete();
        return $this->SuccessResponse("آیتم مورد نظر با موفقیت حذف شد.", 204);
    }
}
