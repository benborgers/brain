<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;
use League\CommonMark\CommonMarkConverter;

class Notecard extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function toHtml()
    {
        $converter = new CommonMarkConverter([
            'html_input' => 'escape'
        ]);

        $html = $converter->convertToHTML(
            $this->markdown
        );

        return Str::of($html)
            // Open links in new tab.
            ->replaceMatches('/<a/', '<a target="_blank"');
    }

    public function folder()
    {
        return $this->belongsTo('App\Models\Folder');
    }
}
