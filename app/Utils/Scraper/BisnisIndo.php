<?php

namespace App\Utils\Scraper;

use DateTime;
use Goutte\Client;


class BisnisIndo extends ParentScraper {  
    
    public function __construct() {
        parent::__construct();
        $this->name = "Bisnis.com";
    }

    public function scrape_search($search) {
        $client = new Client;
        $page = $client->request('GET', "http://search.bisnis.com/?q=".$search);
        
        $page->filterXPath('//div[@class="col-sm-8"]/h2/a')->each(function($article) {
            $this->title[] = $article->text();
                        
            $one_link = $article->link()->getUri();                 
            $this->link[] = $one_link;
            
            $result = $this->scrape_article($one_link);
            $this->bodytext[] = $result["body"];
        });

        $page->filterXPath('//div[@class="col-sm-8"]/div[@class="wrapper-description"]/div[@class="channel"]/div[@class="date"]')->each(function($one_date){
            
            $date_raw = str_replace("WIB","",$one_date->text());
            $date_raw = trim($date_raw);
            //16 Februari 2021 16:25
            $date2 = explode(' ', $date_raw);            
            $date1 = $date2[2].$this->change_month($date2[1]).$date2[0];

            if ($date1 !== '') {
                $date1 = DateTime::createFromFormat('Y-m-j', $date1);
                $this->date[] = $date1->format('Y-m-d'); 
            }

        });
        
    }

    public function scrape_article($url) {
        
        $client = new Client;
        $page = $client->request('GET', $url);
        $body = "";
        
        if (strpos($url, "koran.bisnis") == false) {
            $paras = $page->filterXPath('//div[@class="col-sm-10"]/p');
                
            foreach ($paras as $para) {
                $body = $body . " " . $para->nodeValue;
            }
        } else {
            $body = $page->filter('.wrapper-desc')->text();
        }

        return [
            "body" => $body                   
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

