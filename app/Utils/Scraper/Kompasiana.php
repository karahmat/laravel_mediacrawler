<?php

namespace App\Utils\Scraper;

use DateTime;
use Goutte\Client;


class Kompasiana extends ParentScraper {  
    
    public function __construct() {
        parent::__construct();
        $this->name = "Kompasiana";
    }

    public function scrape_search($search) {
        $client = new Client;
        $page = $client->request('GET', "https://www.kompasiana.com/search_artikel?q=".$search);
        
        $page->filterXPath('//div[@class="artikel--content"]/h2')->each(function($article) {
                       
            if($article->filter('a')->count() > 0) {
                $this->title[] = $article->filter('a')->text();
                $one_link = $article->filter('a')->link()->getUri();
                $this->link[] = $one_link;    
                $result = $this->scrape_article($one_link);
                $this->bodytext[] = $result["body"];
                $this->date[] = $result["date"];             
            }

        });
        
        
    }

    public function scrape_article($url) {
        
        $client = new Client;
        $page = $client->request('GET', $url);
        $body = "";
        $date_final = "";
        $date2="";
              
            
        if ($page->filterXPath("//div[@itemprop='articleBody']/p")->count()>0) {
            $paras = $page->filterXPath("//div[@itemprop='articleBody']/p");
                
            foreach ($paras as $para) {
                $body = $body . " " . $para->nodeValue;
            }
        }
        
        
                
        if ($page->filter('.count-item')->count()>0) {
            $date2 = $page->filter('.count-item')->eq(0)->text();  
            $date1 = explode(' ',$date2);
            $date1 = $date1[2].$this->change_month($date1[1]).$date1[0];
            $date1 = DateTime::createFromFormat('Y-m-d', $date1);
            $date_final = $date1->format('Y-m-d'); 
        }            
        

        return [
            "body" => $body,
            "date" => $date_final               
        ];
        
    }

    public function change_month($month) {

        if ($month == "Januari") {
            $month = "-01-";}
    
        elseif ($month == "Februari") {
            $month = "-02-";}
    
        elseif ($month == "Maret") {
            $month = "-03-" ;}
    
        elseif ($month == "April") {
            $month = "-04-"; }
    
        elseif ($month == "Mei") {
            $month = "-05-"; }
    
        elseif ($month == "Juni") {
            $month = "-06-"; }
    
        elseif ($month == "Juli") {
            $month = "-07-"; }
    
        elseif ($month == "Agustus") {
            $month = "-08-"; }
    
        elseif ($month == "September") {
            $month = "-09-";  }
    
        elseif ($month == "Oktober") {
            $month = "-10-"; }
    
        elseif ($month == "November") {
            $month = "-11-"; }
    
        elseif ($month == "Desember") {
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

