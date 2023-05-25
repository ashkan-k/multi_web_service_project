<?php

namespace Modules\Ticket\Entities;

use App\Http\Traits\Searchable;
use App\Models\Ticket;
use App\Models\TicketCategory;
use App\Models\TicketFrequentlyAskedQuestion;
use App\Models\TicketSubject;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    protected static function newFactory()
    {
        return \Modules\Ticket\Database\factories\TicketAnswerFactory::new();
    }
}
