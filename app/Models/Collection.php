<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [ 'notecards' => 'array' ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($query) {
            $key = '';
            while(! $key) {
                $attempt = friendly_random();
                if(! Collection::where('key', $attempt)->exists()) {
                    $key = $attempt;
                }
            }
            $query->key = $key;

            $query->notecards = [];
        });
    }

    public function scopeInOrder($query)
    {
        return $query->orderByDesc('updated_at');
    }
}
