<x-layout>
    <h3>This is your search results</h3>
    
    <div class="row" style="margin-bottom: 0px">          
            <div class="col s2 heading heading-date">Date</div>              
            <div class="col s10 heading">Snippets</div>          
    </div>
    <div class="resultsTable">
        <x-newsentry :news="$cnn_indo" />
        {{-- <x-newsentry :news="$detik" />
        <x-newsentry :news="$kompas" />
        <x-newsentry :news="$bisnisIndo" /> --}}
        <x-newsentry :news="$jawaPos" />
        <x-newsentry :news="$jakartaPost" />
    </div>

    <p><a href="\">Back</a></p>
    @section('footer-scripts')
        @include('scripts.result-script')
    @endsection
</x-layout>