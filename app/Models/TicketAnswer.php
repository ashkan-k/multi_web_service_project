<?php

namespace App\Models;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TicketAnswer extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'ticket_id',
        'text',
        'file',
    ];

    protected $search_fields = [
        'text',
        'ticket.title',
    ];

    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class);
    }
}
