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

        // Decrease level of headings
        return Str::of($html)
            ->replaceMatches('/<(\/?)h([1-6])>/', fn ($match) => '<' . $match[1] . 'h' . ($match[2] + 1) . '>');
    }

    public function folder()
    {
        return $this->belongsTo('App\Models\Folder');
    }
}
