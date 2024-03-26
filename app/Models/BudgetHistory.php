<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class BudgetHistory extends Model
{
    use HasFactory;

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }
}
