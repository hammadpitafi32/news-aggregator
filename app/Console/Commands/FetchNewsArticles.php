<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\NewsApiService;
use App\Services\GuardianApiService;
use App\Services\NytApiService;

class FetchNewsArticles extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'fetch:news-articles';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and store news articles';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->info('Fetching and storing news api articles...');
        // news api
        $newsService = new NewsApiService();
        $newsService->fetchAndStoreArticles();
        
        // Gardian news
        $gardianService = new GuardianApiService();
        $gardianService->fetchAndStoreArticles();

        // NYT Api
        $nytService = new NytApiService();
        $nytService->fetchAndStoreArticles();

        $this->info('News api articles fetched and stored successfully.');
    }
}
