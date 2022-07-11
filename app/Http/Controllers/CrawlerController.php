<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Observers\CrawlerObserver;
use Spatie\Crawler\CrawlProfiles\CrawlInternalUrls;
use Spatie\Crawler\Crawler;
use GuzzleHttp\RequestOptions;

class CrawlerController extends Controller
{
    /**
     * @param  \Illuminate\Http\Request $objRequest
     * @return \Illuminate\Http\Response
     */
    public function __invoke(Request $objRequest)
    {
        return Crawler::create()->ignoreRobots()
        ->setCrawlObserver(new CrawlerObserver)
        ->startCrawling('http://applicant-test.us-east-1.elasticbeanstalk.com/');
    }

}
