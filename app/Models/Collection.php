<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use App\Models\Notecard;

class Collection extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [ 'notecards' => 'array' ];

    protected $attributes = [ 'notecards' => '[]' ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $key = '';
            while(! $key) {
                $attempt = friendly_random();
                if(! Collection::where('key', $attempt)->exists()) {
                    $key = $attempt;
                }
            }
            $model->key = $key;
        });

        static::saving(function ($model) {
            // Only allow attaching notecards if their owner is the current user.
            $allNotecardsBelongToUser = true;
            foreach($model->notecards as $notecardId) {
                $notecard = Notecard::find($notecardId);
                if(! $notecard->folder->owner->is(auth()->user())) {
                    $allNotecardsBelongToUser = false;
                }
            }

            return $allNotecardsBelongToUser;
        });
    }

    public function scopeInOrder($query)
    {
        return $query->orderByDesc('updated_at');
    }
}
