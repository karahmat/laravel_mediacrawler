<?php

namespace App\Utils\Scraper;

use AlesZatloukal\GoogleSearchApi\GoogleSearchApi as GoogleSearchApiGoogleSearchApi;
use DateTime;
use Google\Service\HangoutsChat\GoogleAppsCardV1DateTimePicker;
use Goutte\Client;

class JawaPos extends ParentScraper {

    public function __construct() {
        parent::__construct();
        $this->name = "Jawapos";
    }

    public function scrape_search($search) {

        $googleSearch = new GoogleSearchApiGoogleSearchApi();
        $googleSearch->setApiKey(env('GOOGLE_DEVELOPER_KEY'));
        $googleSearch->setEngineId('012209424901670165781:fruzhiutzca');
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
        $paras = $page->filter('.content')->filter('p');
        
        foreach ($paras as $para) {
            $body = $body . " " . $para->nodeValue;
         }    
        
        if ($page->filter('.time')->count()>0) {
            $date = $page->filter('.time')->text();
            //18 November 2021, 11:01:42 WIB        
            $date = explode(',',$date)[0];                        
            $day = explode(' ',$date)[0];
            $month = explode(' ',$date)[1];
            $year = explode(' ',$date)[2];
            if ($date !== '') {
                $date_final = $year.$this->change_month($month).$day;
                // $date = DateTime::createFromFormat('j/m/Y', $date);
                // $date_final = $date->format('Y-m-d');  
            }
        }
        
        return [
            "body" => $body,
            "date" => $date_final         
        ];
        
    }

    public function change_month($month) {

        if ($month == "Januari" Or $month == "JAN") {
            $month = "-01-";}
    
        elseif ($month == "Februari" Or $month == "FEB") {
            $month = "-02-";}
    
        elseif ($month == "Maret" Or $month == "Mar") {
            $month = "-03-" ;}
    
        elseif ($month == "April" Or $month == "Apr") {
            $month = "-04-"; }
    
        elseif ($month == "Mei" Or $month == "May") {
            $month = "-05-"; }
    
        elseif ($month == "Juni" Or $month == "Jun") {
            $month = "-06-"; }
    
        elseif ($month == "Juli" Or $month == "Jul") {
            $month = "-07-"; }
    
        elseif ($month == "Agustus" Or $month == "Aug") {
            $month = "-08-"; }
    
        elseif ($month == "September" Or $month == "Sep") {
            $month = "-09-";  }
    
        elseif ($month == "Oktober" Or $month == "Okt") {
            $month = "-10-"; }
    
        elseif ($month == "November" Or $month == "Nov") {
            $month = "-11-"; }
    
        elseif ($month == "Desember" Or $month == "Des") {
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