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
    ];

    protected $guarded = ['status'];
}
