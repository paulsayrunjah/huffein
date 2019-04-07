<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;
use Artisan;

class DbFresh extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'migrate:dbfresh {--f}{--seed}{--all}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Database reconstruction';

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
        try{

            //testing purpose { remove all the files in public folder}
            //\FileManager::cleanDirectory();

            if($this->option('f')){
                echo "Formatting ....... \n";
                Schema::disableForeignKeyConstraints();
                foreach (\DB::select('SHOW TABLES') as $table) {
                    $table_array = get_object_vars($table);
                    if($this->option('all')){
                        \DB::table($table_array[key($table_array)])->truncate();
                    }else{

                    }


                }
                if($this->option('seed')){
                    echo "Seeding...... \n";
                    Artisan::call('db:seed');
                }
                echo "Done !!! \n";
                Schema::enableForeignKeyConstraints();
            }else {
                echo "Dropping tables......... \n";
                Schema::disableForeignKeyConstraints();
                foreach (\DB::select('SHOW TABLES') as $table) {
                    $table_array = get_object_vars($table);
                    \Schema::drop($table_array[key($table_array)]);

                }

                Schema::enableForeignKeyConstraints();
                echo "Migrating...... \n";
                Artisan::call('migrate');
                echo "Seeding...... \n";
                Artisan::call('db:seed');
                echo "Done !!!! \n";
            }
        }catch(Exception $e){
            print($e);
        }
       
    }
}
