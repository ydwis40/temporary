<?php

namespace App\Models;

use App\Support\Models\HasDataTableFilter;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Indication extends Model
{
    use HasFactory;
    use HasDataTableFilter;

    protected $fillable = ['code', 'name'];
}
