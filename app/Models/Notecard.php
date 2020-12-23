<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;
use League\CommonMark\Environment;
use League\CommonMark\Extension\SmartPunct\SmartPunctExtension;

class Notecard extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $key = '';
            while(! $key) {
                $attempt = friendly_random();
                if(! Notecard::where('key', $attempt)->exists()) {
                    $key = $attempt;
                }
            }
            $model->key = $key;
        });
    }

    public function toHtml()
    {
        $environment = Environment::createCommonMarkEnvironment();
        $environment->addExtension(new SmartPunctExtension());
        $converter = new CommonMarkConverter([ 'html_input' => 'escape' ], $environment);

        $html = $converter->convertToHTML(
            $this->markdown ?? ''
        );

        return Str::of($html)
            // Open links in new tab.
            ->replaceMatches('/<a/', '<a target="_blank"');
    }

    public function folder()
    {
        return $this->belongsTo('App\Models\Folder');
    }

    public function scopeInOrder($query)
    {
        return $query->orderByDesc('updated_at');
    }
}
