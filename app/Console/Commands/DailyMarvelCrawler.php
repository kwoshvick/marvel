<?php

namespace App\Console\Commands;

use App\Jobs\MarvelCrawler;
use App\Services\MarvelService;
use Illuminate\Console\Command;

class DailyMarvelCrawler extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'marvelCrawler:cron';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $marvelService = new MarvelService();
        $marvelService->fetchCharacters();
//        MarvelCrawler::dispatch();
    }
}
