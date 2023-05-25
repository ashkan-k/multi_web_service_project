<?php

namespace Modules\Ticket\Entities;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class TicketCategory extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['title'];

    protected $search_fields = [
        'title',
    ];

    protected static function newFactory()
    {
        return \Modules\Ticket\Database\factories\TicketCategoryFactory::new();
    }
}
