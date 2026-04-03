<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cliente extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'clientes';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'cedula';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'cedula',
        'nombre',
        'telefono',
        'correo',
    ];

    /**
     * Get the citas for the cliente.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'id_cliente', 'cedula');
    }
}
