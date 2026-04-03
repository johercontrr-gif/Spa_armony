<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Servicio extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'servicios';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_servicio';

    /**
     * Indicates if the IDs are auto-incrementing.
     */
    public $incrementing = false;

    /**
     * The "type" of the primary key ID.
     */
    protected $keyType = 'int';

    /**
     * The attributes that are mass assignable.
     */
    protected $fillable = [
        'id_servicio',
        'nombre_servicio',
        'precio',
        'descripcion',
    ];

    /**
     * The masajistas that belong to the servicio.
     */
    public function masajistas(): BelongsToMany
    {
        return $this->belongsToMany(
            Masajista::class,
            'masa_servicio',
            'id_servicio',
            'id_masajista'
        )->withPivot('comision')->withTimestamps();
    }

    /**
     * The citas that include this servicio.
     */
    public function citas(): BelongsToMany
    {
        return $this->belongsToMany(
            Cita::class,
            'citas_servicios',
            'id_servicio',
            'id_cita'
        )->withPivot('duracion')->withTimestamps();
    }
}
