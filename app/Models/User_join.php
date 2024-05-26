<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperUser_join
 */
class User_join extends Model
{
    use HasFactory;
    public $timestamps = false;
    
    protected $guarded = [];
}
