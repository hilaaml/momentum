<x-app-layout>
    @include('journal._filter')
    @include('journal._calendar')

    @if ($selectedJournal && !$editMode)
        @include('journal._modal-view')
    @endif

    @if ($selectedJournal && $editMode)
        @include('journal._modal-edit')
    @endif

    @if (!$selectedJournal && $selectedDay)
        @include('journal._modal-create')
    @endif
</x-app-layout>

<script>
    function redirectToDate(date) {
        const url = new URL(window.location.href);
        url.searchParams.set('month', '{{ $month }}');
        url.searchParams.set('year', '{{ $year }}');
        url.searchParams.set('selected', date);
        window.location.href = url.toString();
    }
</script>
