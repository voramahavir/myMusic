<?php

namespace App\Console\Commands;

use Artisan;
use GuzzleHttp\Client;
use Illuminate\Console\Command;

class CreateStorageSymlink extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'storage:symlink';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create symlink for storage public directory.';

    /**
     * Create a new command instance.
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     */
    public function handle()
    {
        if ($this->tryDefaultSymlink() || $this->tryAlternativeSymlink()) {
            $this->info('Created storage symlink successfully.');
            return;
        }

        //reset default symlink
        $this->tryDefaultSymlink();

        $this->warn('Created storage symlink, but it does not seem to be working properly.');
    }

    /**
     * Try alternative symlink creation.
     *
     * @return bool
     */
    private function tryAlternativeSymlink()
    {
        $this->removeCurrentSymlink();
        symlink('../storage/app/public', './storage');

        return $this->symlinkWorks();
    }

    /**
     * Try default laravel storage symlink.
     *
     * @return bool
     */
    private function tryDefaultSymlink()
    {
        $this->removeCurrentSymlink();
        Artisan::call('storage:link');

        return $this->symlinkWorks();
    }

    /**
     * Check if current storage symlink works properly.
     *
     * @return bool
     */
    private function symlinkWorks()
    {
        $http = new Client(['verify' => false, 'exceptions' => false]);
        $response = $http->get(url('storage/symlink_test.txt'))->getBody()->getContents();
        return $response === 'works';
    }

    /**
     * Remove current storage symlink.
     *
     * @return bool
     */
    private function removeCurrentSymlink()
    {
        try {
            return unlink(public_path('storage'));
        } catch (\Exception $e) {
            return false;
        }
    }
}
