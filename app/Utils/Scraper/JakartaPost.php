<?php

namespace App\Utils\Scraper;

use AlesZatloukal\GoogleSearchApi\GoogleSearchApi as GoogleSearchApiGoogleSearchApi;
use DateTime;
use Google\Service\HangoutsChat\GoogleAppsCardV1DateTimePicker;
use Goutte\Client;

class JakartaPost extends ParentScraper {

    public function __construct() {
        parent::__construct();
        $this->name = "Jakarta Post";
    }

    public function scrape_search($search) {

        $googleSearch = new GoogleSearchApiGoogleSearchApi();
        $googleSearch->setApiKey(env('GOOGLE_DEVELOPER_KEY'));
        $googleSearch->setEngineId('007685728690098461931:2lpamdk7yne');
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
        $paras = $page->filter('.detailNews')->filter('p');
        
        foreach ($paras as $para) {
            $body = $body . " " . $para->nodeValue;
         }    
        
        if ($page->filter('.day')->count()>0) {
            $date = $page->filter('.day')->text();
            if (substr_count($date, ',') == 2) {
                #Thu, August 31, 2017
                $month_day = explode(',',$date)[1];
                $year = explode(',',$date)[2];
                $month = explode(' ',$month_day)[1];
                $day = explode(' ',$month_day)[2];
                $date_final = $year.$this->change_month($month).$day;
                $date_final = trim($date_final);
                $date_final = DateTime::createFromFormat('Y-m-d',$date_final)->format('Y-m-d');
              
            } elseif (substr_count($date, ',') == 1) {
               //Sat, September 2 2017
                $m_d_y = explode(',',$date)[1];
                $date1 = explode(' ',$m_d_y);
                $date_final = $date1[3].$this->change_month($date1[1]).$date1[2];
                $date_final = trim($date_final);
                $date_final = DateTime::createFromFormat('Y-m-d',$date_final)->format('Y-m-d');
              
            }

        }
        
        return [
            "body" => $body,
            "date" => $date_final            
        ];
        
    }

    public function change_month($month) {

        if ($month == "January") {
            $month = "-01-";}
    
        elseif ($month == "February") {
            $month = "-02-";}
    
        elseif ($month == "March") {
            $month = "-03-" ;}
    
        elseif ($month == "April") {
            $month = "-04-"; }
    
        elseif ($month == "May") {
            $month = "-05-"; }
    
        elseif ($month == "June") {
            $month = "-06-"; }
    
        elseif ($month == "July") {
            $month = "-07-"; }
    
        elseif ($month == "August") {
            $month = "-08-"; }
    
        elseif ($month == "September") {
            $month = "-09-";  }
    
        elseif ($month == "October") {
            $month = "-10-"; }
    
        elseif ($month == "November") {
            $month = "-11-"; }
    
        elseif ($month == "December") {
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