<?php

namespace App\Utils\Scraper;

use Goutte\Client;


class Detik extends ParentScraper {  
    
    public function __construct() {
        parent::__construct();
        $this->name = "Detik";
    }

    public function scrape_search($search) {
        $client = new Client;
        $page = $client->request('GET', "https://www.detik.com/search/searchnews?query=".$search."&sortby=time&page=1");
        
        $page->filter('article')->each(function($article) {
            
            
            $this->title[] = $article->filter('h2')->text();
                        
            $one_link = $article->filter('a')->link()->getUri();                 
            $this->link[] = $one_link;
            
            $result = $this->scrape_article($one_link);
            $this->bodytext[] = $result["body"];
            $this->date[] = $result["date"];
            

        });
        
    }

    public function scrape_article($url) {
        
        $client = new Client;
        $page = $client->request('GET', $url);
        $body = "";
              
        if (strpos($url, "health.detik.com") == false) {
                
            $paras = $page->filter('.detail__body-text.itp_bodycontent')->filter('p');
                
            foreach ($paras as $para) {
                $body = $body . " " . $para->nodeValue;
            }
            
        } elseif (strpos($url, "health.detik.com") !== false) {
            
            $paras = $page->filter('.itp_bodycontent.detail_text')->filter('p');
            
            foreach ($paras as $para) {
                $body = $body . " " . $para->nodeValue;
            }
            
        }
                
        if (strpos($url, "health.detik.com") !== false) {
            if ($page->filter('.date')->count()==0) {
                $date2 = $page->filter('.detail__date')->text();  
            } else {
                $date2 = $page->filter('.date')->eq(0)->text(); 
            }            
            //Selasa, 09 Nov 2021 15:40 WIB         
        } else {
            $date2 = $page->filter('.detail__date')->text();          
        }
        
        //Senin, 08 Nov 2021 18:09 WIB
        //Rabu, 10 Nov 2021 00:05 WIB
        $date1 = explode(',', $date2)[1];
        
        //$date1 = explode(' ',$date1);
        //$date_final = $date1[3].$this->change_month($date1[2]).$date1[1];
        
        if (str_contains($date2, 'Views')) {
            $date1 = explode(' Views ',$date2)[1];
            $date1 = explode(',', $date1)[1];
            $date1 = explode(' ', $date1);                        
            $date_final = $date1[3].$this->change_month($date1[2]).$date1[1];
        } else {
            $date1 = explode(',', $date2)[1];            
            $date1 = explode(' ',$date1);
            $date_final = $date1[3].$this->change_month($date1[2]).$date1[1];
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

