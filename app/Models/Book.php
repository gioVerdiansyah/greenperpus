<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Book extends Model
{
    use HasUuids;
    public function categories(): BelongsToMany
    {
        return $this->belongsToMany(BookCategory::class, "book_category", "book_id", "book_category_id");
    }

    public function getFormattedCategoriesAttribute()
    {
        return $this->categories->pluck('name')->implode(', ');
    }
}
