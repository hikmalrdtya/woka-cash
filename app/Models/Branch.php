<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Branch extends Model
{
    //
    protected $fillable = [
        'user_id',
        'name',
        'alamat'
    ];

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function staff()
    {
        return $this->belongsToMany(User::class, 'branch_users');
    }

    public function projects() {
        return $this->hasMany(Project::class, 'branch_id');
    }

    public function incomes() {
        return $this->hasMany(Income::class, 'branch_id');
    }
    
    public function budgetRequest() {
        return $this->hasMany(BudgetRequest::class, 'branch_id');
    }

    public function expense() {
        return $this->hasMany(Expense::class, 'branch_id');
    }
}
