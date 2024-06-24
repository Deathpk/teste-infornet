<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Service extends Model
{
    const SERVICES_PER_PAGE = 10;
    use HasFactory, SoftDeletes;

    protected $guarded = [];

}
