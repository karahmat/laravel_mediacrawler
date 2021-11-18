
@props(["news"])
@for ($i=0; $i<count($news["title"]); $i++) 
    <div class="row resultRow" style="margin-bottom: 0px">
        <div class="col s2 dateCol">{{ $news["date"][$i] }}</div>                  
        <div class="col s10 snippetsCol"><span class="titleNews">{{ $news["name"] }}: <a href="{{ $news['link'][$i] }}">{{ $news["title"][$i] }}</a></span><br /><br /> {{ substr($news["body"][$i], 0, 500) }}<span class="moreText inv">{{ substr($news["body"][$i], 500) }}</span><span class="clickMore">...Read More</span></div>
    </div>
@endfor

