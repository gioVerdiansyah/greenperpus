<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class BookReview extends Model
{
    use HasUuids;

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
    public function bookCollections(): HasMany
    {
        return $this->hasMany(BookCollection::class);
    }
    public function borrows(): HasMany
    {
        return $this->hasMany(Borrowing::class);
    }
}
