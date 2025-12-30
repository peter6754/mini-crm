<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Ticket extends Model implements HasMedia
{
    /** @use HasFactory<\Database\Factories\TicketFactory> */
    use HasFactory, InteractsWithMedia;

    protected $fillable = [
        'theme',
        'text',
        'status',
        'answered_at',
        'customer_id',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function scopeLastDay($query)
    {
        return $query->where('created_at', '>=', now()->subDay());
    }

    public function scopeLastWeek($query)
    {
        return $query->where('created_at', '>=', now()->subWeek());
    }

    public function scopeLastMonth($query)
    {
        return $query->where('created_at', '>=', now()->subMonth());
    }
}
