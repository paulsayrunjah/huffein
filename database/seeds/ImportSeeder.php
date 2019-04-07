<?php

use Illuminate\Database\Seeder;

class ImportSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // -
        //  \App\User::create([
        //     "name" => "Pauuz",
        //     "email" => "pauuz@email.com",
        //     "password" => bcrypt('admin1')
        // ]);

        $currency = ["UGX", "USD", "KSH", "TSH"];
        $status = ["processed", "entered", "rejected"];

        //$start_date = \Carbon\Carbon::parse("2018-11-15");
        //$stop_date = \Carbon\Carbon::parse("2018-11-25");

        $start_date = \Carbon\Carbon::now()->subDays(10);
        $stop_date = \Carbon\Carbon::now();


        while ($start_date < $stop_date) {
            $dates[] = $start_date->addDay()->format("Y-m-d");
        }

        foreach($dates as $date){
            $records_data = [];
            foreach($currency as $curr){
               $record = \App\InwardRecord::create([
                    "currency" => $curr,
                    "amount" => mt_rand(1000, 20000),
                    "items" => mt_rand(20, 70),
                    "date" => $date,
                    "status" => $status[mt_rand(0,2)]
                ]);

                $records_data[] = $record->id;
            }

            \App\ImportLog::create([
                "import_date" => $date,
                "records_imported" => json_encode($records_data) 
            ]);
        }

        

    }
}
