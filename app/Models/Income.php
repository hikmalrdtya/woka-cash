<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Income extends Model
{
    protected $fillable = [
        'branch_id',
        'user_id',
        'project_id',
        'amount',
        'description',
        'date',
        'role_in_branch'
    ];

    public function branch() {
        return $this->belongsTo(Branch::class, 'branch_id');
    }

    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function project() {
        return $this->belongsTo(Project::class, 'project_id');
    }
}
