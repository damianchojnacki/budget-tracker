<?php

namespace App\Models;

use Database\Factories\BudgetFactory;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

/**
 * These properties are sometimes dynamically added to the model via custom query
 * and potentially have not been set at any given time.
 *
 * @property-read ?float $sum
 */
class Budget extends Model
{
    /** @use HasFactory<BudgetFactory> */
    use HasFactory;

    /**
     * @return BelongsTo<Organization, $this>
     */
    public function organization(): BelongsTo
    {
        return $this->belongsTo(Organization::class);
    }

    /**
     * @return HasManyThrough<User, Organization, $this>
     */
    public function users(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Organization::class);
    }

    /**
     * @return BelongsTo<Currency, $this>
     */
    public function currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class);
    }

    /**
     * @return HasMany<BudgetHistory, $this>
     */
    public function history(): HasMany
    {
        return $this->hasMany(BudgetHistory::class)->latest();
    }

    /**
     * @return HasMany<Transaction, $this>
     */
    public function transactions(): HasMany
    {
        return $this->hasMany(Transaction::class)->latest();
    }
}
