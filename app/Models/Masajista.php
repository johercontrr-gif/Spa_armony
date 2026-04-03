<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Masajista extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'masajistas';

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
        'nombre_masajista',
        'telefono',
    ];

    /**
     * Get the citas for the masajista.
     */
    public function citas(): HasMany
    {
        return $this->hasMany(Cita::class, 'masajista', 'cedula');
    }

    /**
     * The servicios that belong to the masajista.
     */
    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(
            Servicio::class,
            'masa_servicio',
            'id_masajista',
            'id_servicio'
        )->withPivot('comision')->withTimestamps();
    }
}
