{{-- Redirect /today to today's note based on browser date --}}

@include('includes/frontend-variables')

<script src="{{ mix('js/app.js') }}"></script>

<script>
    window.location = window.TODAY_ROUTE
</script>
