<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ticket extends Model
{
    use HasFactory;

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

//    protected $guarded = ['status'];

    public static function query()
    {
        $query = parent::query();
        // TODO: Check if use is not admin, show only current user tickets
        if (!auth()->user()->is_admin){
            $query = $query->where('user_id', auth()->id());
        }
        return $query;
    }
}
