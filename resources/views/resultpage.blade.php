<x-layout>
    <h3>This is your search results</h3>
    
    <div class="row">          
            <div class="col s2">Date</div>              
            <div class="col s10">Snippets</div>          
    </div>
        
            <x-newsentry :news="$cnn_indo" />
            <x-newsentry :news="$detik" />
            <x-newsentry :news="$kompas" />
        
      <p><a href="\">Back</a></p>
</x-layout>