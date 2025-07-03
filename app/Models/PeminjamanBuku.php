<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PeminjamanBuku extends Model
{
    use HasFactory;

    protected $fillable = [
        'item_no',
        'book_title',
        'borrower_name',
        'borrower_faculty',
        'loan_date',
        'due_date',
        'return_date',
    ];
}
