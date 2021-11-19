<?php

namespace App\Utils\Scraper;

use AlesZatloukal\GoogleSearchApi\GoogleSearchApi as GoogleSearchApiGoogleSearchApi;
use DateTime;
use Google\Service\HangoutsChat\GoogleAppsCardV1DateTimePicker;
use Goutte\Client;

class Republika extends ParentScraper {

    public function __construct() {
        parent::__construct();
        $this->name = "Republika";
    }

    public function scrape_search($search) {

        $googleSearch = new GoogleSearchApiGoogleSearchApi();
        $googleSearch->setApiKey(env('GOOGLE_DEVELOPER_KEY'));
        $googleSearch->setEngineId('partner-pub-4715833796533077:6447497648');
        $parameters = array("sort"=>"Date");

        $results = $googleSearch->getResults($search, $parameters); 
        
        foreach($results as $result) {
            $this->title[] = $result->title;
            $this->link[] = $result->link;    
            $articlebody = $this->scrape_article($result->link); 
            $this->bodytext[] = $articlebody["body"];
            $this->date[] = $articlebody["date"];
        }
        
        
    }

    public function scrape_article($url) {
        
        $client = new Client();
        $page = $client->request('GET', $url);
        $body = "";
        $date_final = "";
        if ($page->filter(".artikel")->count() > 0) {
            $body = $page->filter(".artikel")->text();
        }

        if ($page->filter('.date_detail > p')->count()>0) {
            $date2 = $page->filter('.date_detail > p')->text();
            //Rabu 17 Nov 2021 21:39 WIB
            $date_exploded = explode(' ',$date2);     
            $date = $date_exploded[3].$this->change_month($date_exploded[2]).$date_exploded[1];
            $date = DateTime::createFromFormat('Y-m-d', $date);
            $date_final = $date->format('Y-m-d');    
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
    
        elseif ($month == "May") {
            $month = "-05-"; }
    
        elseif ($month == "Jun") {
            $month = "-06-"; }
    
        elseif ($month == "Jul") {
            $month = "-07-"; }
    
        elseif ($month == "Agu" or $month == "Aug") {
            $month = "-08-"; }
    
        elseif ($month == "Sep") {
            $month = "-09-";  }
    
        elseif ($month == "Oct") {
            $month = "-10-"; }
    
        elseif ($month == "Nov") {
            $month = "-11-"; }
    
        elseif ($month == "Dec") {
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