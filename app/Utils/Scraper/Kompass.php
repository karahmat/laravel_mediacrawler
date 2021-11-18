<?php

namespace App\Utils\Scraper;

use AlesZatloukal\GoogleSearchApi\GoogleSearchApi as GoogleSearchApiGoogleSearchApi;
use DateTime;
use Google\Service\HangoutsChat\GoogleAppsCardV1DateTimePicker;
use Goutte\Client;

class Kompass extends ParentScraper {

    public function __construct() {
        parent::__construct();
        $this->name = "Kompas.com";
    }

    public function scrape_search($search) {

        $googleSearch = new GoogleSearchApiGoogleSearchApi();
        $googleSearch->setApiKey(env('GOOGLE_DEVELOPER_KEY'));
        $googleSearch->setEngineId('018212539862037696382:-xa61bkyvao');
        $parameters = array("sort"=>"Date");

        $results = $googleSearch->getResults($search, $parameters); 
        
        foreach($results as $result){
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
        $paras = $page->filter('.read__content')->filter('p');
        
        foreach ($paras as $para) {
            $body = $body . " " . $para->nodeValue;
         }    
        
        if ($page->filter('.read__time')->count()>0) {
            $date = $page->filter('.read__time')->text();
            //Kompas.com - 08/05/2021, 12:59 WIB        
            $date = explode(' ',$date)[2];            
            $date = str_replace(',','',$date);
            $day = explode('/',$date)[0];
            $month = explode('/',$date)[1];
            $year = explode('/',$date)[2];
            if ($date !== '') {
                $date = $day.'/'.$this->change_month($month).'/'.$year;
                $date = DateTime::createFromFormat('j/m/Y', $date);
                $date_final = $date->format('Y-m-d');  
                $date_final = DateTime::createFromFormat('Y-m-d',$date_final)->format('Y-m-d');
            }
        }
        
        return [
            "body" => $body,
            "date" => $date_final            
        ];
        
    }

    public function change_month($month) {
        if ($month == "Jan") {
            $month = "01";}
    
        elseif ($month == "Feb") {
            $month = "02";}
    
        elseif ($month == "Mar") {
            $month = "03" ;}
    
        elseif ($month == "Apr") {
            $month = "04"; }
    
        elseif ($month == "May") {
            $month = "05"; }
    
        elseif ($month == "Jun") {
            $month = "06"; }
    
        elseif ($month == "Jul") {
            $month = "07"; }
    
        elseif ($month == "Aug") {
            $month = "08"; }
    
        elseif ($month == "Sep") {
            $month = "09";  }
    
        elseif ($month == "Oct") {
            $month = "10"; }
    
        elseif ($month == "Nov") {
            $month = "11"; }
    
        elseif ($month == "Dec") {
            $month = "12"; }
    
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