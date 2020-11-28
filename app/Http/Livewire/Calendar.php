<?php

namespace App\Http\Livewire;

use Livewire\Component;
use Illuminate\Support\Arr;

use Carbon\CarbonPeriod;

class Calendar extends Component
{
    public function render()
    {
        $firstNote = auth()->user()->notes()
            ->oldestByDate()
            ->first();
        
        $period = array_reverse(CarbonPeriod::create(
            $firstNote->dateAsCarbon()->startOfWeek(),
            now()->addWeek()->startOfWeek()->subDay()
        )->toArray());

        $weeks = array_chunk($period, 7);
        $reversedWeeks = [];

        foreach($weeks as $week) {
            $reversedWeeks[] = array_reverse($week);
        }

        $notes = auth()->user()->notes()
            ->get('date');

        return view('livewire.calendar', [
            'dates' => Arr::flatten($reversedWeeks),
            'notes' => $notes
        ]);
    }
}
