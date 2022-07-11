<?php

namespace App\Observers;

use DOMDocument;
use Spatie\Crawler\CrawlObservers\CrawlObserver;
use Psr\Http\Message\UriInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\RequestException;
use Illuminate\Support\Facades\Log;
use Spatie\Crawler\Crawler;

class CrawlerObserver extends CrawlObserver
{
    private $content;

    public function __construct ()
    {
        $this->content = NULL;
    }

    /**
     * @param \Psr\Http\Message\UriInterface $strUrl
     */
    public function willCrawl(UriInterface $strUrl): void
    {
        Log::info('Iniciando rastreio', ['url' => $strUrl]);
    }

    /**
     * @param \Psr\Http\Message\UriInterface $strUrl
     * @param \Psr\Http\Message\ResponseInterface $objResponse
     * @param \Psr\Http\Message\UriInterface|null $strFoundOnUrl
     */
    public function crawled (
        UriInterface $strUrl,
        ResponseInterface $objResponse,
        ?UriInterface $strFoundOnUrl = null
    ): void {
        Crawler::create([
            'url' => $strUrl
        ], [
            'status' => $objResponse->getStatusCode()
        ]);
    }

    /**
     * @param \Psr\Http\Message\UriInterface $strUrl
     * @param \GuzzleHttp\Exception\RequestException $objRequestException
     * @param \Psr\Http\Message\UriInterface|null $strFoundOnUrl
     */
    public function crawlFailed (
        UriInterface $strUrl,
        RequestException $objRequestException,
        ?UriInterface $strFoundOnUrl = null
    ): void {
        Log::error('Falha em rastreio.', ['url' => $strUrl, 'error' => $objRequestException->getMessage()]);
    }

    public function finishedCrawling(): void
    {
        Log::info("Finalizando rastreio.");
    }
}