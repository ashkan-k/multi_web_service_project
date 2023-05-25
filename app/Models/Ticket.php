<?php

namespace App\Models;

use App\Http\Traits\Searchable;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory, Searchable;

    protected $fillable = [
        'user_id',
        'ticket_category_id',
        'ticket_frequently_asked_id',
        'ticket_subject_id',
        'title',
        'text',
        'file',
        'status',
    ];

    protected $search_fields = [
        'title',
        'text',
        'ticket_category.title',
        'ticket_frequently_asked.title',
        'ticket_subject.title',
    ];

//    protected $guarded = ['status'];

    public static function query()
    {
        $query = parent::query();
        // TODO: Check if use is not admin, show only current user tickets
        if (!auth()->user()->is_admin) {
            $query = $query->where('user_id', auth()->id());
        }
        return $query;
    }

    //

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function ticket_category()
    {
        return $this->belongsTo(TicketCategory::class);
    }

    public function ticket_frequently_asked()
    {
        return $this->belongsTo(TicketFrequentlyAskedQuestion::class);
    }

    public function ticket_subject()
    {
        return $this->belongsTo(TicketSubject::class);
    }
}
