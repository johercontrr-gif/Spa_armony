<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Cita extends Model
{
    use HasFactory;

    /**
     * The table associated with the model.
     */
    protected $table = 'citas';

    /**
     * The primary key for the model.
     */
    protected $primaryKey = 'id_cita';

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
        'id_cita',
        'fecha',
        'masajista',
        'id_cliente',
        'nota',
        'estado',
        'habitacion',
    ];

    /**
     * Get the attributes that should be cast.
     */
    protected function casts(): array
    {
        return [
            'fecha' => 'datetime',
        ];
    }

    /**
     * Get the cliente that owns the cita.
     */
    public function cliente(): BelongsTo
    {
        return $this->belongsTo(Cliente::class, 'id_cliente', 'cedula');
    }

    /**
     * Get the masajista that owns the cita.
     */
    public function masajistaRelation(): BelongsTo
    {
        return $this->belongsTo(Masajista::class, 'masajista', 'cedula');
    }

    /**
     * The servicios included in this cita.
     */
    public function servicios(): BelongsToMany
    {
        return $this->belongsToMany(
            Servicio::class,
            'citas_servicios',
            'id_cita',
            'id_servicio'
        )->withPivot('duracion')->withTimestamps();
    }

    /**
     * Calculate total price from related services.
     */
    public function getTotalAttribute(): int
    {
        return $this->servicios->sum('precio');
    }

    /**
     * Calculate total duration in minutes.
     */
    public function getDuracionTotalAttribute(): int
    {
        return $this->servicios->sum('pivot.duracion') ?? 0;
    }
}
