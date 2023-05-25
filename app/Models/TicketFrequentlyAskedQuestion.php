<?php

namespace App\Models;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketFrequentlyAskedQuestion extends Model
{
    use HasFactory, Searchable;

    protected $fillable = ['title'];

    protected $search_fields = [
        'title',
    ];
}
