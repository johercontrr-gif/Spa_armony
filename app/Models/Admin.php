<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Admin extends Authenticatable
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'admin';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_admin';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'usuario',
        'contrasena',
    ];

    /**
     * The attributes that should be hidden for serialization.
     */
    protected $hidden = [
        'contrasena',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'contrasena' => 'hashed',
        ];
    }

    /**
     * Get the password for the user (override for custom column name).
     */
    public function getAuthPassword(): string
    {
        return $this->contrasena;
    }
}
