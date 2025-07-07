<x-app-layout>
    @include('journal._filter')
    @include('journal._calendar')

    @if ($selectedJournal && !$editMode)
        @include('journal._modal-view')
    @endif

    @if ($selectedJournal && $editMode)
        @include('journal._modal-edit')
    @endif

    @if (!$selectedJournal && $selectedDay && !\Carbon\Carbon::parse($selectedDay)->isFuture())
        @include('journal._modal-create')
    @elseif (!$selectedJournal && $selectedDay && \Carbon\Carbon::parse($selectedDay)->isFuture())
        <x-modal name="future-date-warning" :show="true">
            <div class="p-6">
                <h2 class="font-bold text-gray-800 dark:text-gray-100">Cannot Create Journal</h2>
                <p class="my-4 text-gray-600 dark:text-gray-300">You cannot create journal entries for future dates.</p>
                <div class="flex justify-end">
                    <x-secondary-button type="button" x-on:click="$dispatch('close-modal', 'future-date-warning')">Close</x-secondary-button>
                </div>
            </div>
        </x-modal>
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'future-date-warning'
                }));
            });
        </script>
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
