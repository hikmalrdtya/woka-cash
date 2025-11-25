<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OcrResult extends Model
{
    //
    protected $fillable = [
        'expense_id',
        'raw_text',
        'parsed_total',
        'parsed_date',
        'parsed_store',
    ];

    public function expense() {
        return $this->belongsTo(Expense::class, 'expense_id');
    }
}
