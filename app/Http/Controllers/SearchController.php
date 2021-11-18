<?php

namespace App\Http\Controllers;

use App\Utils\Scraper\BisnisIndo;
use App\Utils\Scraper\CnnIndo;
use App\Utils\Scraper\Detik;
use App\Utils\Scraper\JakartaPost;
use App\Utils\Scraper\JawaPos;
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
        
        // $detik = new Detik;
        // $detik->scrape_search($search);

        // $kompas = new Kompass;
        // $kompas->scrape_search($search);

        // $bisnisIndo = new BisnisIndo;
        // $bisnisIndo->scrape_search($search);

        $jawaPos = new JawaPos;
        $jawaPos->scrape_search($search);

        $jakartaPost = new JakartaPost;
        $jakartaPost->scrape_search($search_eng);
        
        
        return view('resultpage', [
            "cnn_indo" => $cnn_indo->getVariables(),
            // "detik" => $detik->getVariables(),
            // "kompas" => $kompas->getVariables(),
            // "bisnisIndo" => $bisnisIndo->getVariables()
            "jawaPos" => $jawaPos->getVariables(),
            "jakartaPost" => $jakartaPost->getVariables()
        ]);   
           
    }
}
