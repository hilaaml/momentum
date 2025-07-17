<x-app-layout>
    <div class="space-y-6">

        @include('rewards._header')
        @include('rewards._add-modal')

        @if ($rewards->count())
            @include('rewards._list')
        @else
            @include('rewards._empty')
        @endif

    </div>
</x-app-layout>
