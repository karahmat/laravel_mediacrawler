<?php

namespace App\Utils\Scraper;

use DateTime;
use Goutte\Client;
use Nesk\Puphpeteer\Puppeteer;
use Nesk\Rialto\Data\JsFunction;

class CnnIndo extends ParentScraper {  
    
    public function __construct() {
        parent::__construct();
        $this->name = "CNN Indonesia";
    }

    public function scrape_search($search) {        
        $puppeteer = new Puppeteer;

        $browser = $puppeteer->launch([ 'args' => ['--no-sandbox'] ]);

        $page = $browser->newPage();
        $page->goto('https://www.cnnindonesia.com/search/?query='.$search);    
        $articles = $page->querySelectorAll('article:not([class])'); 
        foreach ($articles as $article) {
            $this->title[] = $article->querySelector('.title')->evaluate(JsFunction::createWithParameters(['node'])->body('return node.innerText;'));
            $one_link = $article->querySelector('a')->evaluate(JsFunction::createWithParameters(['node'])->body('return node.href;'));
            $this->link[] = $one_link;
            $result = $this->scrape_article($one_link);
            $this->bodytext[] = $result["body"];
            $this->date[] = $result["date"];
        }
        $browser->close();
    }

    public function scrape_article($url) {
        $client = new Client();
        $page = $client->request('GET', $url);
        $body = "";

        $paras = $page->filter('#detikdetailtext')->filter('p');

        foreach ($paras as $para) {
           $body = $body . " " . $para->nodeValue;
        }        

        $date2 = $page->filter('.content_detail > .date')->text();  

        $date2 = trim($date2);
        // Ruptly, CNN Indonesia | Kamis, 18 Nov 2021 21:33 WIB
        if (str_contains($date2, '|')) {
            $date1 = explode('|',$date2)[1];
            $date1 = explode(',', $date2)[2];
            //18 Nov 2021 18:59 WIB
            $date_array = explode(' ', $date1);
            $date_final = $date_array[3].$this->change_month($date_array[2]).$date_array[1];
            $date_final = DateTime::createFromFormat('Y-m-d',$date_final)->format('Y-m-d');
            
        } else {
            $date1 = explode(',', $date2)[1];
            $date1 = explode(' ',$date1);
            $date_final = $date1[3].$this->change_month($date1[2]).$date1[1];
            $date_final = DateTime::createFromFormat('Y-m-d',$date_final)->format('Y-m-d');
        }
              
                
        return [
            "body" => $body,
            "date" => $date_final                  
        ];
        
    }

    public function change_month($month) {
        if ($month == "Jan") {
            $month = "-01-";}
    
        elseif ($month == "Feb") {
            $month = "-02-";}
    
        elseif ($month == "Mar") {
            $month = "-03-" ;}
    
        elseif ($month == "Apr") {
            $month = "-04-"; }
    
        elseif ($month == "Mei") {
            $month = "-05-"; }
    
        elseif ($month == "Jun") {
            $month = "-06-"; }
    
        elseif ($month == "Jul") {
            $month = "-07-"; }
    
        elseif ($month == "Agu" or $month == "Aug") {
            $month = "-08-"; }
    
        elseif ($month == "Sep") {
            $month = "-09-";  }
    
        elseif ($month == "Okt") {
            $month = "-10-"; }
    
        elseif ($month == "Nov") {
            $month = "-11-"; }
    
        elseif ($month == "Des") {
            $month = "-12-"; }
    
        else {
            $month = $month; }
    
        return $month;
    // end of change month function
    }

    public function getVariables() { 
        return [
            "name" => $this->name,
            "title" => $this->title,
            "link" => $this->link,
            "date" => $this->date,
            "body" => $this->bodytext
        ];
    }
    
}

