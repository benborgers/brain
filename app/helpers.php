<?php

function get_random_word($name)
{
    $path = resource_path("words/{$name}.txt");
    $file = Str::of(file_get_contents($path));
    $words = $file->split('/\n/')->filter();
    return $words->random();
}

function friendly_random()
{
    return get_random_word('predicates') . '-' . get_random_word('objects');
}
