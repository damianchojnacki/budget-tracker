<?php

namespace App\Models;

use App\Enums\CurrencyType;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $id
 * @property CurrencyType $type
 * @property string $name
 * @property string $code
 * @property string|null $symbol
 * @property float $rate
 * @property Carbon $created_at
 * @property Carbon $updated_at
 */
class Currency extends Model
{
    use HasFactory;

    protected $casts = [
        'type' => CurrencyType::class,
    ];

    public function budgets(): HasMany
    {
        return $this->hasMany(Budget::class);
    }

    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }
}
