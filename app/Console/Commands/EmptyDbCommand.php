<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Review;
use App\Product;
use App\User;
use DB;
use File;
use Storage;

class EmptyDbCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:empty';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Empty ur DB';

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
     * @return mixed
     */
    public function handle()
    {
        $emptyDb = $this->emptyDb();
        $deleteFiles = $this->deleteFiles();
    }

    /**
     * Ask for empty db.
     */
    private function emptyDb()
    {
        
        $res = $this->ask('You want to delete all data ? ( yes || no )');
        
        if ( $res == 'yes' ){

            DB::statement('SET FOREIGN_KEY_CHECKS=0;');
            Review::truncate();
            Product::truncate();
            User::truncate();
            DB::statement('SET FOREIGN_KEY_CHECKS=1;');
            
            $this->info('All data was deleted!');
        }
    }

    /**
     * Ask for empty images folder.
     */
    private function deleteFiles()
    {
        
        $res = $this->ask('You want to delete all images ? ( yes || no )');
        
        if ( $res == 'yes' ){

            $this->emptyDir('storage/app/public/image/');
            $this->info('All files was deleted!');
        }
        
        $this->info('Thanks');
    }

    /**
     * delete all files and folders.
     */
    public static function emptyDir($dirPath) {
        
        if ( is_dir( $dirPath ) ) {
            
            if (substr($dirPath, strlen($dirPath) - 1, 1) != '/') {
                $dirPath .= '/';
            }
            $files = glob($dirPath . '*', GLOB_MARK);
            foreach ($files as $file) {
                if (is_dir($file)) {
                    self::emptyDir($file);
                } else {
                    unlink($file);
                }
            }
        }
    }
}
