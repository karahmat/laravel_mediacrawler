<?php

namespace App\Utils\Scraper;

use AlesZatloukal\GoogleSearchApi\GoogleSearchApi as GoogleSearchApiGoogleSearchApi;
use DateTime;
use Google\Service\HangoutsChat\GoogleAppsCardV1DateTimePicker;
use Goutte\Client;

class Merdeka extends ParentScraper {

    public function __construct() {
        parent::__construct();
        $this->name = "Merdeka.com";
    }

    public function scrape_search($search) {

        $googleSearch = new GoogleSearchApiGoogleSearchApi();
        $googleSearch->setApiKey(env('GOOGLE_DEVELOPER_KEY'));
        $googleSearch->setEngineId('001561947424278099921:7qnaw_9r2rq');
        $parameters = array("sort"=>"Date");

        $results = $googleSearch->getResults($search, $parameters); 
        
        foreach($results as $result){
            if (strpos($result->link, ".html")) {
                $this->title[] = $result->title;
                $this->link[] = $result->link;    
                $articlebody = $this->scrape_article($result->link); 
                $this->bodytext[] = $articlebody["body"];
                $this->date[] = $articlebody["date"];
            }
        }
        
        
    }

    public function scrape_article($url) {
        
        $client = new Client();
        $page = $client->request('GET', $url);
        $body = "";
        $date_final = "";
        $paras = $page->filter('.mdk-body-paragraph')->filter('p');
        
        foreach ($paras as $para) {
            $body = $body . " " . $para->nodeValue;
         }    
        
        if ($page->filter('.date-post')->count()>0) {
            $date = $page->filter('.date-post')->text();
            //Kamis, 18 November 2021 23:33     
            $date = explode(',',$date)[1];            
            $date = trim($date);
            $day = explode(' ',$date)[0];
            $month = explode(' ',$date)[1];
            $year = explode(' ',$date)[2];
            if ($date !== '') {
                $date = $year.$this->change_month($month).$day;
                $date = DateTime::createFromFormat('Y-m-d', $date);
                $date_final = $date->format('Y-m-d');                  
            }
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