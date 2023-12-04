<?php
// app/Services/NewsService.php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Http;

class NewsApiService
{
	private $apiKey;

	public function __construct()
    {
    	// newsapi key
        $this->apiKey = env('NEWSAPI_KEY');
    }

    public function fetchAndStoreArticles()
    {

        $newsData = $this->fetchDataFromExternalSource();

        foreach ($newsData as $data) {
        	if(!empty($data)){

        		Article::create([
	                'title' => $data['title'],
	                'description' => $data['description'],
	                'source' => $data['source'],
	                'category' => $data['category'],
	                'author' => $data['author'],
	                'image_url' => $data['image_url'],
	                'content' => $data['content'],
	                'published_at' => $data['published_at'],
            	]);
        	}
            
        }
    }

    private function fetchDataFromExternalSource()
    {
        $response = Http::get('https://newsapi.org/v2/top-headlines', [
            'apiKey' => $this->apiKey,
            'country' => 'us', // Set your desired country or remove this parameter
        ]);

        $articles = $response->json()['articles'];

        return array_map(function ($article) {

        	if(strlen($article['title']) >= 5 && strlen($article['content']) >= 12){
        		return [
	                'title' => $article['title'],
	                'description' => $article['description'],
	                'source' => $article['source']['name'],
	                'category' =>'General', // You may want to extract this information from the article's content or other fields
	                'image_url' => $article['urlToImage'],
	                'content' => $article['content'],
	                'author' => $article['author'],
	                'published_at' => $article['publishedAt'],
            	];
        	}
            
        }, $articles);
    }
}
