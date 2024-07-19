<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UrlModel extends Model
{
    use HasFactory;
    protected $table = 'table_urls';
    protected $primaryKey = 'id';

    public $timestamps = false;
    protected $fillable = [
        'linkName',
    ];
}
