<x-layout>        
    <h3>Key in your words below<h3>
    
    <form method="POST" action="/search" class="col s12">
        @csrf
        <div class="row">
        <div class="input-field col s12">
            <input id="search" name="search" type="text" required class="validate">
            <label for="search">Search Word (Indonesian)</label>
        </div>            
        </div>  
        <div class="row">
        <div class="input-field col s12">
            <input id="last_name" name="search_eng" type="text" required class="validate">
            <label for="last_name">Search Word (English)</label>
        </div>
        </div>
        <button class="btn waves-effect waves-light" type="submit" name="action">Submit
            <i class="material-icons right">send</i>
        </button>
    </form>    
</x-layout>