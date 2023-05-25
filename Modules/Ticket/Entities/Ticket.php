<?php

namespace Modules\Ticket\Entities;

use App\Http\Traits\Searchable;
use App\Models\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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

    public function newQuery($excludeDeleted = true)
    {
        $query = parent::newQuery($excludeDeleted);
        if (!auth()->user()->is_admin) {
            $query = $query->where('user_id', auth()->id());
        }
        return $query;
    }

    public function scopeFilter($query, $request)
    {
        $status = $request->status;
        if ($status) {
            $query->Where('status', $status);
        }

        $user = $request->user;
        if ($status) {
            $query->Where('user_id', $user);
        }

        $ticket_category = $request->ticket_category;
        if ($ticket_category) {
            $query->Where('ticket_category_id', $ticket_category);
        }

        $ticket_frequently_asked = $request->ticket_frequently_asked;
        if ($ticket_frequently_asked) {
            $query->Where('ticket_frequently_asked_id', $ticket_frequently_asked);
        }

        $ticket_subject = $request->ticket_subject;
        if ($ticket_subject) {
            $query->Where('ticket_subject_id', $ticket_subject);
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

    public function answers()
    {
        return $this->hasMany(TicketAnswer::class);
    }

    protected static function newFactory()
    {
        return \Modules\Ticket\Database\factories\TicketFactory::new();
    }
}
