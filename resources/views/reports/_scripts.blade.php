@push('scripts')
<script>
    window.heatmapData = @json($dailyData ?? []);
    window.heatmapStart = "{{ $from ?? now()->toDateString() }}";

    document.addEventListener('DOMContentLoaded', () => {
        if (typeof window.initReportCharts === 'function') {
            window.initReportCharts(
                @json($byDay),
                @json($byHour),
                @json($projectLabels),
                @json($projectValues)
            );
        }
    });
</script>
@endpush
