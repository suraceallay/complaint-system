<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Laravel\Sanctum\HasApiTokens;

class Complaint extends Model
{
    use HasFactory; use HasApiTokens;
    protected $table = 'complaints';
    protected $fillable = [
        'complain'
    ];
}
