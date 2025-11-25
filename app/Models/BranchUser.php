<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BranchUser extends Model
{
    protected $fillable = [
        'branchId',
        'userId',
        'roleInBranch'
    ];

    public function branchStaff()
    {
        return $this->belongsTo(User::class, 'userId');
    }
}
