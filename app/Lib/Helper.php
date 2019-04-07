<?php

define("PERFOMED_ON", "performedOn");
define("CAUSED_BY", "causedBy");
define("WITH_PROPERTIES", "withProperties");
define("LOG", "log");

use Carbon\Carbon;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Eloquent\Model;

function today($format = 'd/M/Y')
{
    return Carbon::now()->format($format);
}

function getColumnList($model)
{
    return Schema::getColumnListing($model->getTable());
}

function toMoney($value)
{
    if (is_decimal($value)) {
        return number_format($value, 2);
    }

    return number_format($value);
}

function is_decimal($val)
{
    return is_numeric($val) && floor($val) != $val;
}

