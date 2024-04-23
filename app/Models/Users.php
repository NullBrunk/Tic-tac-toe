<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Users extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function find_by_mail(string $mail) {
        return tap($this) -> where("email", "=", $mail);
    }
}
