<x-app-layout>
    @include('reports._scripts')

    <div class="mx-auto space-y-6 text-center">

        @include('reports._filter-form')
        @include('reports._character')

        @if ($totalSeconds > 0)
            @include('reports._summary-stats')
            @include('reports._charts')
            @include('reports._timeline')
        @else
            @include('reports._empty')
        @endif

    </div>
</x-app-layout>
