<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'branch_id',
        'description'
    ];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }
    
    public function incomes() {
        return $this->hasMany(Income::class, 'project_id');
    }

    public function expense() {
        return $this->hasMany(Expense::class, 'project_id');
    }
}
