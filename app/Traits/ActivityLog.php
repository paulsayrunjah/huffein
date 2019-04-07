<?php


use Illuminate\Database\Eloquent\Model;
use Spatie\Activitylog\Models\Activity as MyActivityLogger;

trait ActivityLog
{

    public static $changes = [];

    public function __construct()
    {
        //on modal update
        static::getModelChanges($this);
    }
    

    static function simplelogging($description, $name = "")
    {
        activity($name)->log($description);
    }
/*
    param : collection
    ['performedOn?' : model, 'causedBy?' : user, 'withProperties?' : array, 'log' : string]
     */
    static function advancedlog($options, $name = "default")
    {
        //log updates
        if (isset($options[PERFOMED_ON])) {
           
            $model = $options[PERFOMED_ON];
            if(!isset($options[WITH_PROPERTIES])){
                $options[WITH_PROPERTIES] = [];
            }
            $options[WITH_PROPERTIES] = (count(static::$changes) > 0) ? static::$changes : $options[WITH_PROPERTIES];
        
        }

        $options = static::organiseLog($options);
    
        $log = activity($name);

        if (!$options->has("log")) {
            return;
        }

        foreach ($options as $key => $value) {
            $log->{$key}($value);
        }
        dd(MyActivityLogger::all()->last()->changes);
    }

    static function getModelChanges()
    {
        self::updating(function (Model $model){
            $new = $model->getDirty();
            $old = [];
            foreach ($new as $key => $val) {
                $old[$key] = $model->getOriginal($key);
            }
            static::$changes = [
                "attributes" => $new,
                "old" => $old,
            ];
        });
    }

    static function organiseLog($options)
    {
        $orderedOptions = [];
        $order = [PERFOMED_ON, CAUSED_BY, WITH_PROPERTIES, LOG];
        foreach($order as $val){
            if($options->has($val)){
                $orderedOptions[$val] = $options[$val];
            }
        }
        return collect($orderedOptions);
        
    }
    
}
