<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OpptyProject extends Model
{
    use HasFactory;

    protected $guarded = [];

    public function detailtmreim()
    {
        return $this->hasMany(TransactionMakerReimbursement::class, 'opptyproject_id');
    }
}
