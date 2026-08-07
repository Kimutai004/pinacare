<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ImpactMetric extends Model
{
    protected $fillable = ['diapers_saved','co2_reduced','farmers_supported'];
}
