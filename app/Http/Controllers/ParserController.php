<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\DomCrawler\Crawler;

class ParserController extends Controller
{
    public function index()
    {
        $url = 'https://72.ru/text/';
        $crawler = new Crawler(file_get_contents($url));
//        $crawler->addHtmlContent($url, 'UTF-8');
//        dd($crawler);

            $title = $crawler->filter('.B3gd > .M-a21')->text();


        dd($title);
//        foreach ($cravler as $news){
//            var_dump($news->filter('title'));
//        }
    }
}
