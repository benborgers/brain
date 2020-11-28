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

        $positions = [];
        for($i = 0; $i < mb_strlen($lowercaseContents); $i++) {
            $pos = mb_strpos($lowercaseContents, $string, $i);
            if($pos === $i) {
                $positions[] = $pos;
            }
        }

        foreach($positions as $position) {
            $padding = 40;

            $firstStart = $position - $padding;
            $firstLength = $padding;

            if($position < $padding) {
                $firstStart = 0;
                $firstLength = $position;
            }

            $line = mb_substr($contents, $firstStart, $firstLength)
                        . '<mark class="bg-yellow-200 text-yellow-900">'
                        . mb_substr($contents, $position, mb_strlen($string))
                        . '</mark>'
                        . mb_substr($contents, $position + mb_strlen($string), $padding);
            
            $output[] = Str::of($line)
                ->trim();
        }

        return $output;
    }

    public function scopeLatestByDate($query)
    {
        return $query->orderByDesc('date');
    }

    public function scopeOldestByDate($query)
    {
        return $query->orderBy('date');
    }
}
