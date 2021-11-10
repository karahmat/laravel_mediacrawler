## PHP Media Scrawler with Laravel

This is the same media crawler which I had originally built using purely with PHP. It has now been organised with Laravel 8. I used Blade templates and Materialize as the CSS framework

The codes are currently organised for use in a Docker container and Laravel Sail. 

## Libraries

I had to use the following libraries that did not come pre-packaged with Laravel:

- [PuPHPeteer - A Puppeteer bridge for PHP](https://laravel-news.com/puphpeteer)
- [Goutte, a simple PHP Web Scraper](https://goutte.readthedocs.io/en/latest/)
- Google Custom Search Engine (a Google API Client) - This is because some new sites use GCSE for their search engine. I made use of a library coded by [aleszatloukal](https://github.com/aleszatloukal/google-search-api)

## News Sites crawled

This programme currently only scrapes through three news sites. As each site has its own unique set of HTML, I had to create three separate classes to scrape each of them. Each of them inherit an abstract parent class. The classes for each scraper are stored in the App\Utils\Scraper namespace.

