<?php

namespace App\Http\Controllers;
use App\Utils\Scraper\CnnIndo;
use App\Utils\Scraper\Detik;
use App\Utils\Scraper\Kompass;
use Illuminate\Http\Request;


class SearchController extends Controller
{
   

    public function search(Request $request) 
    {
        
        $search = $request->input('search');   
        $search_eng = $request->input('search_eng');  
        
        $cnn_indo = new CnnIndo;
        $cnn_indo->scrape_search($search);
        
        $detik = new Detik;
        $detik->scrape_search($search);

        $kompas = new Kompass;
        $kompas->scrape_search($search);
        
        
        return view('resultpage', [
            "cnn_indo" => $cnn_indo->getVariables(),
            "detik" => $detik->getVariables(),
            "kompas" => $detik->getVariables()
        ]);   
           
    }
}
