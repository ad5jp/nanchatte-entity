<?php

namespace App\Models;

use App\Domain\Book\Book as BookEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $book_id
 * @property string $book_title
 * @property string $author_name
 * @property int $total_pages
 * @property Carbon $published_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 *
 * @property Collection<Chapter> $chapters
 */
class Book extends Model
{
    protected $table = "m_books";
    protected $primaryKey = 'book_id';

    protected $casts = [
        'book_id' => 'integer',
		'total_pages' => 'integer',
		'published_date' => 'datetime',
		'created_at' => 'datetime',
		'updated_at' => 'datetime',
    ];

    public function chapters(): HasMany
    {
        return $this->hasMany(Chapter::class, 'book_id', 'book_id');
    }

    public function toEntity(): BookEntity
    {
        return new BookEntity($this);
    }
}
