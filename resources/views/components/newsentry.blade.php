@props(["news"])
@for ($i=0; $i<count($news["title"]); $i++) 
    <div class="row">
        <div class="col s2">{{ $news["date"][$i] }}</div>                  
        <div class="col s10">{{ $news["name"] }}: <a href="{{ $news['link'][$i] }}">{{ $news["title"][$i] }}</a><br /><br /> {{ substr($news["body"][$i], 0, 800) }}...</div>
    </div>
@endfor