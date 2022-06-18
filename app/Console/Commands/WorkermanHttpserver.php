<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Workerman\Worker;
use App;
use Illuminate\Support\Facades\DB;

class WorkermanHttpserver extends Command
{
    protected $httpserver;
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'workerman:httpserver {action} {--daemonize}';
    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'workerman httpserver';

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
        // because workerman Need to take parameters   So you have to force changes 
        global $argv;
        $action = $this->argument('action');
        if (!in_array($action, ['start','stop'])) {
            $this->error('Error Arguments');
            exit;
        }
        $argv[0] = 'workerman:httpserver';
        $argv[1] = $action;
        $argv[2] = $this->option('daemonize') ? '-d' : '';
        $this->httpserver = new Worker('http://0.0.0.0:2346');
        // App::instance('workerman:httpserver',$this->httpserver);
        $this->httpserver->onMessage = function ($connection, $data) {
            $user = DB::table('users')->first();
            //$user = json_decode(json_encode($user), 1);
            $connection->send(json_encode($user));
            $connection->send('laravel workerman hello world');
        };
        Worker::runAll();
    }
}
