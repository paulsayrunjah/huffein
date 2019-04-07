<?php 

class Graph{

    // return (object)[
    //     "labels" => $labels,
    //     "datasets" => [(object)[
    //         "data" => $data,
    //         "borderWidth" => "1",
    //         "pointRadius" => "1",
    //         "borderColor" => "#A4A1FB",
    //         "fill" => true,
    //         "gradientColor" => (object)[
    //             "stop" => "rgba(186, 184, 252, 0.3)",
    //             "start" => "rgba(255, 255, 255, 0.1)",
    //         ]
    //     ]]
    // ];

    public $collection;

    public function __construct($collection)
    {
        $this->collection = $collection;    
    }

    public function formGraph(){
        return (object)[
            "labels" => $this->collection->keys()->toArray(),
            "datasets" => [(object)[
                "data" => $this->collection->values()->toArray(),
                "borderWidth" => "1",
                "pointRadius" => "1",
                "borderColor" => "#A4A1FB",
                "fill" => true,
                "gradientColor" => (object)[
                    "stop" => "rgba(186, 184, 252, 0.3)",
                    "start" => "rgba(255, 255, 255, 0.1)",
                ]
            ]]
        ];
    }


}