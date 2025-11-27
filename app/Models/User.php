<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    /** @use HasFactory<\Database\Factories\UserFactory> */
    use HasFactory, Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var list<string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
        'role',
        'photo_profile',
    ];

    public function leaderBranch() {
        return $this->hasMany(Branch::class, 'user_id');
    }

    public function staffBranch() {
        return $this->belongsToMany(Branch::class, 'branch_users');
    }

    public function incomes() {
        return $this->hasMany(Income::class, 'user_id');
    }

    public function budgetRequest() {
        return $this->hasMany(budgetRequest::class, 'user_id');
    }

    public function userApproved() {
        return $this->hasMany(BudgetRequest::class, 'approved_by');
    }

    public function expense() {
        return $this->hasMany(Expense::class, 'user_id');
    }

    public function verifiedExpense() {
        return $this->hasMany(Expense::class, 'verified_by');
    }

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var list<string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }
}
