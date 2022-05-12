<?php

namespace App\Console\Commands;

use App\Models\Post;
use App\Models\User;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Http;

class ImportData extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'data:import';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Import data from api';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }


    public function handle()
    {
        $response = Http::get(config('services.import.url'));

        $response->collect('data')->lazy()->each(function ($item, $key) {
            Post::firstOrCreate(
                ['title'=> $item['title']],
                ['title' =>  $item['title'],
                 'user_id' => User::where('owner', true)->first()->id,
                 'description' => $item['description'],
                 'created_at' => $item['publication_date']]
            );

        });

        $this->info('The command was successful!');

    }
}
