<?php

namespace App\Utils\Scraper;

abstract class ParentScraper {
    public function __construct(
        protected $name = "",
        protected $title = array(),
        protected $link = array(),
        protected $date = array(),  
        protected $bodytext = array()
    ) {

    }

    abstract public function scrape_search($search);
    abstract protected function scrape_article($url);
    abstract public function change_month($month);
    abstract public function getVariables();
}