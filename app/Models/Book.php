<?php

namespace App\Models;

use App\Entities\Book as BookEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

/**
 * @property int $book_id
 * @property string $book_title
 * @property string $author_name
 * @property int $total_pages
 * @property Carbon $published_date
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 */
class Book extends Model
{
    protected $table = "m_books";
    protected $primaryKey = 'book_id';

    protected $dates = [
        'published_date',
        'created_at',
		'updated_at',
    ];

    protected $casts = [
        'book_id' => 'integer',
		'total_pages' => 'integer',
		'published_date' => 'date:Y-m-d',
		'created_at' => 'date:Y-m-d H:i:s',
		'updated_at' => 'date:Y-m-d H:i:s',
    ];

    public function chapters() : HasMany
    {
        return $this->hasMany(Chapter::class, 'book_id', 'book_id');
    }

    public function toEntity(): BookEntity
    {
        return new BookEntity($this);
    }
}
