<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RoleRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'role_demande',
        'justification',
        'piece_jointe',
        'statut',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
}

}