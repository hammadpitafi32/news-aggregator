<?php
// app/Services/NewsService.php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Http;

class NytApiService
{
	private $apiKey;
    // private $secret;
    // private $appId;

	public function __construct()
    {
    	// NYT Api key
        $this->apiKey = env('NYTAPI_KEY');
        // $this->secret = 'nHb9X3V6vwcpMmWG';
        // $this->appId='7b40cbf3-0455-49b2-9a9e-ba20ff1272be';
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
	                // 'image_url' => $data['image_url'],
	                'content' => $data['content'],
	                'published_at' => $data['published_at'],
            	]);
        	}
            
        }
    }

    private function fetchDataFromExternalSource()
    {
        
        $response = Http::get('https://api.nytimes.com/svc/search/v2/articlesearch.json?api-key='.$this->apiKey);

        
        if ($response->successful()) {
            $articles = $response->json()['response']['docs'];
           
            return array_map(function ($article) {
                return [
                    'title' => $article['headline']['main'],
                    'description' => $article['abstract'],
                    'source' => 'New York Times',
                    'category' => $article['section'] ?? 'General',
                    'author' => $article['byline']['original'] ?? '',
                    'published_at' => $article['pub_date'],
                    'content' => $article['web_url'], // You may need to fetch full content from the article's URL
                ];
            }, $articles);
        } else {
            throw new \Exception("Error fetching data from New York Times API. HTTP Status Code: {$response->status()}");
        }
    }
}
