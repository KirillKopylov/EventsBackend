<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Event extends Model
{
    use HasFactory;

    protected $fillable = ['city', 'date', 'title'];

    public function members()
    {
        return $this->hasMany(EventUser::class, 'event_id');
    }
}
