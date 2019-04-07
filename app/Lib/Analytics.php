<?php

use Carbon\Carbon;
class Analytics{

    private static $sortByDates = ['updated_at', 'created_at', 'date'];
    private $data = null;
    private $attributes = null;
    private static $sortedData = [];

    public function __construct($data, $attributes){
        $this->data = $data;
        $this->attributes = $attributes;
    }

    public static function analytics(){
        return self;
    }

    public function getData($attribute = null){
       return ($attribute) ? self::$sortedData[$attribute] : self::$sortedData;
    }

    public function analyze(){
        self::$sortedData = $this->sortDataBy();
        return $this;
    }

    public function groupDataBy($data,$groupBy){
        return $data->groupBy(function($item) use ($groupBy){
            return (collect(self::$sortByDates)->contains($groupBy)) ? Carbon::parse($item[$groupBy])->format("Y-m-d") : $item[$groupBy].'';
        }); 
    }

    public function sortDataBy()
    {
        $data = [];
        foreach ($this->attributes as $attribute) {
            $data[$attribute] = $this->groupDataBy($this->data, $attribute);
        }
        return  (count($data) > 0) ? collect($data) : $this->data;
    }

    public function groupByLevel2($collection, $attribute){

        return $collection->map(function ($item, $key) use ($attribute) {
            return $this->groupDataBy($item, $attribute);
        });

    }

    public static function getTotalValues($collection){

        return $collection->map(function($item ,$key){
            $data = [];
            foreach($item as $k => $val){
                $data2 = [];
                foreach($val->toArray() as $k2 => $v2){
                    if(is_numeric($v2)) $data2[$k2] = $v2;
                }

                $data[] = $data2;
            }
            return $data; 
            
        });
    }

    public static function sumValues($collection, $sumBy){
       return $collection->map(function ($item) use ($sumBy) {
            return collect($item)->pluck($sumBy)->sum();
        });
    }

    public static function mapByCount($collection){
        return $collection->map(function($item){
            return $item->count();
        });
    }

}