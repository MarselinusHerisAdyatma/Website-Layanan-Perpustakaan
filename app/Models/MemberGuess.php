<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class MemberGuess extends Model
{
    protected $connection = 'mysql_xampp';
    protected $table = 'memberguesses';
    protected $primaryKey = 'ID';
    public $timestamps = false;
    
}