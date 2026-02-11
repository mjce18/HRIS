<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LeaveType extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'code',
        'days_allowed',
        'description',
        'status',
    ];

    protected $casts = [
        'days_allowed' => 'integer',
    ];

    public function leaves()
    {
        return $this->hasMany(Leave::class);
    }
}
