<?php
// app/Services/NewsService.php

namespace App\Services;

use App\Models\Article;
use Illuminate\Support\Facades\Http;

class GuardianApiService
{
	private $apiKey;

	public function __construct()
    {
    	// Guardian Api key
        $this->apiKey = env('GUARDIANAPI_KEY');
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
        
        $response = Http::get('http://content.guardianapis.com/search?order-by=newest&show-fields=bodyText&api-key='.$this->apiKey);

        if ($response->successful()) {
            
            $articles = $response->json()['response']['results'];
  
            $data = [];

            foreach ($articles as $article) {

                $data[] = [
                    'title' => $article['webTitle'],
                    'description' => $article['fields']['trailText'] ?? '',
                    'source' => 'The Guardian',
                    'category' => $article['sectionName'] ?? 'General',
                    'author' => $article['fields']['byline'] ?? '',
                    'published_at' => $article['webPublicationDate'],
                    'content' => $article['fields']['bodyText'],
                ];
            }

            return $data;
        } else {
            throw new \Exception("Error fetching data from external source. HTTP Status Code: {$response->status()}");
        }
    }
}
