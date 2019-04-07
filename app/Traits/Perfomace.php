<?php

trait Perfomace{

    public static $status = ["rejected", "entered", "processed"];


    static function stats($analysis_for = "currency"){
        $today = \Carbon\Carbon::now()->format("Y-m-d");
        $last5days = \Carbon\Carbon::now()->subDays(4)->format("Y-m-d");

        $model = new \App\InwardRecord;
        $model_data = $model->where(function($q) use ($today, $last5days){
            $q->whereDate("date", ">=", $last5days)->whereDate("date" , "<=", $today);
        })->get();

       
        $an = new Analytics($model_data, getColumnList($model));
        $data = $an->analyze()->getData($analysis_for);

        $status = $an->groupByLevel2($data, "status");
        $status_items = self::itemStats($status, self::$status);
        $status_graph = self::statusGraph($status_items);

        


        $currency = $an->groupByLevel2($data, "currency");
        $all_currencies = $model_data->pluck("currency")->unique();
        $currency_items = self::itemStats($currency, $all_currencies);
        $currency_graph = self::currencyGraph($currency_items, $all_currencies);

        return (object)[
            "status_graph" => $status_graph,
            "currency_graph" => $currency_graph 
        ];
        
    }

    static function itemStats($collections, $expected_values = null){
        return $collections->map(function ($item, $key) {
            return Analytics::sumValues($item, "items");
        })->map(function ($item, $key) use ($expected_values) {
            if($expected_values){
                foreach ($expected_values as $status) {
                    if (!$item->has($status)) {
                        $item->put($status, 0);
                    }
                }
            }
            return $item;
        });
    }

    static function currencyGraph($data, $currencies){

        $colors = [];

        $final_data = [];
        $count = 0;
        foreach ($currencies as $currency) {
            $color = self::randomColor();
            $final_data[] = (object)[
                "data" => $data->pluck($currency)->toArray(),
                "label" => strtoupper($currency),
                "borderColor" => $color,
                "backgroundColor" => $color
            ];

            $count++;
        }

        return (object)[
            "type" => "bar",
            "data" => (object)[
                "labels" => $data->keys()->toArray(),
                "datasets" => $final_data
            ],
            "options" => (object)[
                "title" => (object)[
                    "display" => "true",
                    "text" => "Inward Records By Currency"
                ],
            ]
        ];
    }

    static function randomColor(){
        $letters = explode(",","0,1,2,3,4,5,6,7,8,9,A,B,C,D,E,F");
        $color = "#";
        for($i =1; $i <=6; $i++){
            $color .= $letters[mt_rand(0, count($letters) -1)];
        }
        $reject = collect(["#000000", "#FFFFFF"]);
        if($reject->contains($color)){
            self::randomColor();
        }

        return $color;

    }

    static function statusGraph($data){

        $colors = ["#c45850" ,"#3e95cd","#3cba9f"] ;
        $final_data = [];
        $count = 0;
        foreach(self::$status as $status){
            $final_data[] = (object)[
                "data" => $data->pluck($status)->toArray(),
                "label" => ucfirst($status),
                "borderColor" => $colors[$count],
                "fill" => "false"
            ];

            $count++;
        }

        return (object)[
            "type" => "line",
            "data" => (object)[
                "labels" => $data->keys()->toArray(),
                "datasets" => $final_data
            ],
            "options" => (object)[
                "title" => (object)[
                    "display" => "true",
                   "text" => "Inward Records By Status"
                ],
            ]
        ];
    }
}