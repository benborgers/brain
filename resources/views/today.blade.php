{{-- Redirect /today to today's note based on browser date --}}
<x-app-layout>
    <div x-data x-init="window.location = window.TODAY_ROUTE"></div>
</x-app-layout>