<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Variation extends Model
{
    protected $fillable = [
        'material_id',
        'color',
        'color_code',
        'weight',
    ];

    protected function casts(): array
    {
        return [
            'weight' => 'decimal:2',
        ];
    }

    public function material(): BelongsTo
    {
        return $this->belongsTo(Material::class);
    }

    public function getPercentageAttribute(): ?float
    {
        if (!$this->material->fixed_weight || $this->material->fixed_weight == 0) {
            return null;
        }

        return ($this->weight / $this->material->fixed_weight) * 100;
    }

    public function getStatusAttribute(): array
    {
        $percentage = $this->percentage;

        if ($percentage === null) {
            return [
                'label' => 'Indefinido',
                'color' => 'gray',
                'bg' => 'bg-gray-100',
                'text' => 'text-gray-800',
            ];
        }

        if ($percentage <= 10) {
            return [
                'label' => 'Estoque Baixo',
                'color' => 'red',
                'bg' => 'bg-red-100',
                'text' => 'text-red-800',
            ];
        }

        if ($percentage <= 50) {
            return [
                'label' => 'Na Metade',
                'color' => 'yellow',
                'bg' => 'bg-yellow-100',
                'text' => 'text-yellow-800',
            ];
        }

        return [
            'label' => 'Estoque Cheio',
            'color' => 'green',
            'bg' => 'bg-green-100',
            'text' => 'text-green-800',
        ];
    }
}
