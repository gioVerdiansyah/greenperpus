<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Concerns\HasUuids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class BookCategory extends Model
{
    use HasUuids;

    public function books(): BelongsToMany
    {
        return $this->belongsToMany(Book::class, "book_category", "book_category_id", "book_id");
    }
}
