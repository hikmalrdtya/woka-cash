<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BudgetRequest extends Model
{
    protected $fillable = [
        'user_id',
        'branch_id',
        'title',
        'amount',
        'note',
        'status',
        'date_submission',
        'approved_by',
        'approved_at'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function approvedBy() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function expense() {
        return $this->hasMany(Expense::class, 'budget_request_id');
    }
}
