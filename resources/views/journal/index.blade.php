<x-app-layout>
    <!-- Filter bar untuk memilih bulan dan tahun -->
    @include('journal._filter')

    <!-- Kalender tampilan utama -->
    @include('journal._calendar')

    <!-- Modal: menampilkan jurnal terpilih jika tidak dalam mode edit -->
    @if ($selectedJournal && !$editMode)
        @include('journal._modal-view')
    @endif

    <!-- Modal: menampilkan form edit jika sedang dalam mode edit -->
    @if ($selectedJournal && $editMode)
        @include('journal._modal-edit')
    @endif

    <!-- Modal: membuat jurnal baru jika hari dipilih, belum ada jurnal, dan bukan tanggal masa depan -->
    @if (!$selectedJournal && $selectedDay && !\Carbon\Carbon::parse($selectedDay)->isFuture())
        @include('journal._modal-create')

    <!-- Modal: peringatan jika user mencoba membuat jurnal untuk tanggal di masa depan -->
    @elseif (!$selectedJournal && $selectedDay && \Carbon\Carbon::parse($selectedDay)->isFuture())
        <!-- Komponen modal untuk warning -->
        <x-modal name="future-date-warning" :show="true">
            <div class="p-6">
                <h2 class="font-bold text-gray-800 dark:text-gray-100">Cannot Create Journal</h2>
                <p class="my-4 text-gray-600 dark:text-gray-300">
                    You cannot create journal entries for future dates.
                </p>
                <div class="flex justify-end">
                    <x-secondary-button
                        type="button"
                        x-on:click="$dispatch('close-modal', 'future-date-warning')"
                    >
                        Close
                    </x-secondary-button>
                </div>
            </div>
        </x-modal>

        <!-- Auto buka modal saat halaman dimuat -->
        <script>
            document.addEventListener('DOMContentLoaded', () => {
                window.dispatchEvent(new CustomEvent('open-modal', {
                    detail: 'future-date-warning'
                }));
            });
        </script>
    @endif
</x-app-layout>

<!-- Redirect ke tanggal tertentu di kalender -->
<script>
    function redirectToDate(date) {
        const url = new URL(window.location.href);
        url.searchParams.set('month', '{{ $month }}');
        url.searchParams.set('year', '{{ $year }}');
        url.searchParams.set('selected', date);
        window.location.href = url.toString();
    }
</script>
