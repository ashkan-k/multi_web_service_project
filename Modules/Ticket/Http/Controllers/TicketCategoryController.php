<?php

namespace Modules\Ticket\Http\Controllers;

use App\Http\Requests\TicketCategoryRequest;
use App\Http\Traits\Responses;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use Modules\Ticket\Entities\TicketCategory;

class TicketCategoryController extends \App\Http\Controllers\Controller
{
    use Responses;

    public function index()
    {
        $ticket_categories = TicketCategory::Search(\request('search'))->paginate(env('PAGINATION_NUMBER', 10));
        return $this->SuccessResponse($ticket_categories);
    }

    public function store(TicketCategoryRequest $request)
    {
        $ticketCategory = TicketCategory::create($request->all());
        return $this->SuccessResponse(TicketCategory::find($ticketCategory->id), 201);
    }

    public function update(TicketCategoryRequest $request, TicketCategory $category)
    {
        $category->update($request->all());
        return $this->SuccessResponse(TicketCategory::find($category->id));
    }

    public function destroy(TicketCategory $category)
    {
        $category->delete();
        return $this->SuccessResponse("آیتم مورد نظر با موفقیت حذف شد.", 204);
    }
}
