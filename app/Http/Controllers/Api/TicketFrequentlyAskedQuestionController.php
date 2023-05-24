<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TicketFrequentlyAskedQuestionRequest;
use App\Http\Traits\Helpers;
use App\Models\TicketFrequentlyAskedQuestion;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class TicketFrequentlyAskedQuestionController extends Controller
{
    use Helpers;

    public function index()
    {
        $ticketFrequentlyAskedQuestions = TicketFrequentlyAskedQuestion::paginate(env('PAGINATION_NUMBER', 10));
        return $this->SuccessResponse($ticketFrequentlyAskedQuestions);
    }

    public function store(TicketFrequentlyAskedQuestionRequest $request)
    {
        $ticketCategory = TicketFrequentlyAskedQuestion::create($request->all());
        return $this->SuccessResponse(TicketFrequentlyAskedQuestion::find($ticketCategory->id), 201);
    }

    public function update(TicketFrequentlyAskedQuestionRequest $request, TicketFrequentlyAskedQuestion $ticketFrequentlyAskedQuestion)
    {
        $ticketFrequentlyAskedQuestion->update($request->all());
        return $this->SuccessResponse(TicketFrequentlyAskedQuestion::find($ticketFrequentlyAskedQuestion->id));
    }

    public function destroy(TicketFrequentlyAskedQuestion $ticketFrequentlyAskedQuestion)
    {
        $ticketFrequentlyAskedQuestion->delete();
        return $this->SuccessResponse("آیتم مورد نظر با موفقیت حذف شد.", 204);
    }
}
