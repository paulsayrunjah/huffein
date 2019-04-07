<?php

namespace App\Console\Commands;

use App\DBDumps;
use Carbon\Carbon;
use Illuminate\Console\Command;

class DBHelper extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'db:helper {--r} {--b}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'database command helpers like backup, restore';

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

            $user = env("DB_USERNAME");
            $passowrd = env("DB_PASSWORD");
            $host = env("DB_HOST");
            $db_name = env("DB_DATABASE");

            if($this->option("r")){

                /*foreach (DBDumps::all() as $dump){
                    echo  "Name: ".$dump->name." => Description: ".$dump->description."\n";
                }*/

                $restore = $this->ask("restore");
                $path = public_path("storage/db/dumps/".$restore);

                if(strtolower($restore) == "exit"){
                    return;
                }

                if(env("APP_ENV") == "local"){
                    $command = "mysql  -h {$host} -u {$user} -p{$passowrd} {$db_name} < {$path}";
                }else{
                    $command = "mysql  -h {$host} -u {$user} -p{$passowrd} {$db_name} < {$path}";
                }

                exec($command);
                echo "Done!!....\n";

            }else{
                echo "Backing up....\n";

                if (!file_exists(public_path("storage/db/dumps/"))) {
                    mkdir(public_path("storage/db/dumps/"), 0777, true);
                }

                $back_up_desc = $this->ask('name');

                $dump_name = $back_up_desc.".sql";
                $path = public_path("storage/db/dumps/".$dump_name);

                if(env("APP_ENV") == "local"){
                    $command = "mysqldump --opt -h {$host} -u {$user} -p{$passowrd} {$db_name} > {$path}";
                }else{
                    $command = "mysqldump --opt -h {$host} -u {$user} -p{$passowrd} {$db_name} > {$path}";
                }

                $desc = $this->ask('Back up description');

                DBDumps::create([
                    "name" => $dump_name,
                    "file_path" => $path,
                    "file_link" => "db/dumps/".$dump_name,
                    "description" => $desc
                ]);


                exec($command);
                echo "Done!!....\n";
            }

        }catch (\Exception $exception){
            print($exception);
        }
    }

}
