<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Arr;

use Carbon\CarbonPeriod;

class Calendar extends Component
{
    public function render()
    {
        $notes = auth()->user()->notes()
            ->get('date');

        $firstNote = $notes->sortBy('date')->first();

        $period = array_reverse(CarbonPeriod::create(
            $firstNote ? $firstNote->dateAsCarbon()->startOfWeek() : now(),
            now()->addWeek()->startOfWeek()->subDay()
        )->toArray());

        $weeks = array_chunk($period, 7);
        $reversedWeeks = [];

        foreach($weeks as $week) {
            $output = [];
            $weekHasANote = false;

            foreach($week as $date) {
                $note = $notes->where('date', $date->format('Y-m-d'))->first();
                if($note) $weekHasANote = true;
                $output[] = [
                    'date' => $date,
                    'note' => $note
                ];
            }

            if($weekHasANote) $reversedWeeks[] = array_reverse($output);
        }

        $dates = [];
        foreach($reversedWeeks as $week) {
            foreach($week as $day) {
                $dates[] = $day;
            }
        }

        return view('livewire.calendar', [
            'dates' => $dates
        ]);
    }
}
