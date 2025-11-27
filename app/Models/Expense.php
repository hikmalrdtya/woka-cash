<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Expense extends Model
{
    protected $fillable = [
        'budget_request_id',
        'user_id',
        'branch_id',
        'project_id',
        'jumlah',
        'note_number',
        'store_name',
        'expense_date',
        'receipt_file',
        'verified_by',
        'verified_at',
    ];

    public function budgetRequest() {
        return $this->belongsTo(BudgetRequest::class, 'budget_request_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }

    public function verifiedBy() {
        return $this->belongsTo(User::class, 'verified_by');
    }
    
    public function expense() {
        return $this->hasOne(OcrResult::class, 'expense_id');
    }
    
}
