<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

use Carbon\Carbon;

class Note extends Model
{
    use HasFactory;

    protected $guarded = [];

    protected $casts = [
        'tags' => 'array'
    ];

    public function dateAsCarbon()
    {
        return Carbon::parse($this->date);
    }

    public function fullHumanDate()
    {
        return $this->dateAsCarbon()->format('l, F jS, Y');
    }

    public function setTags($tags)
    {
        $tags = $tags->map(fn ($x) => strtolower($x));
        $tags = $tags->toArray();
        $this->tags = $tags;
    }

    public function contentsWithoutHtml()
    {
        return Str::of(html_entity_decode($this->contents))
            ->replaceMatches('/<.*?>/', ' ');
    }

    public function highlightedContents($string)
    {
        $string = strtolower($string);
        
        $output = [];
        $contents = $this->contentsWithoutHtml();
        $lowercaseContents = strtolower($contents);
        preg_match_all('/' . preg_quote($string) . '/', $lowercaseContents, $matches, PREG_OFFSET_CAPTURE);

        foreach($matches[0] as $match) {
            $position = $match[1];

            $padding = 30;

            $firstStart = $position - $padding;
            $firstLength = $padding;

            if($position < $padding) {
                $firstStart = 0;
                $firstLength = $position;
            }

            $output[] = substr($contents, $firstStart, $firstLength)
                        . '<mark class="bg-yellow-200 text-yellow-900">'
                        . substr($contents, $position, strlen($string))
                        . '</mark>'
                        . substr($contents, $position + strlen($string), $padding);
        }

        return $output;
    }

    public function scopeLatestByDate($query)
    {
        return $query->orderByDesc('date');
    }
}
