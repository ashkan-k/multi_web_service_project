<?php

namespace App\Http\Controllers\Api;

use App\Http\Requests\TicketCategoryRequest;
use App\Http\Traits\Responses;
use App\Models\TicketCategory;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Tests\Integration\Database\EloquentHasManyThroughTest\Category;

class TicketCategoryController extends Controller
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
