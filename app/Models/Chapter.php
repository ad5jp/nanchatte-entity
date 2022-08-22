<?php

declare(strict_types=1);

namespace App\Models;

use App\Domain\Book\Chapter as ChapterEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property int $chapter_id
 * @property int $book_id
 * @property string $chapter_title
 * @property int $sequence
 * @property int $start_page
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @property Collection<Paragraph> $paragraphs
 */
class Chapter extends Model
{
    protected $table = "m_chapters";
    protected $primaryKey = 'chapter_id';

    protected $dates = [
        'created_at',
		'updated_at',
    ];

    protected $casts = [
        'chapter_id' => 'integer',
		'book_id' => 'integer',
		'sequence' => 'integer',
		'start_page' => 'integer',
		'created_at' => 'date:Y-m-d H:i:s',
		'updated_at' => 'date:Y-m-d H:i:s',
    ];

    public function book() : BelongsTo
    {
        return $this->belongsTo(Book::class, 'book_id', 'book_id');
    }

    public function paragraphs() : HasMany
    {
        return $this->hasMany(Paragraph::class, 'chapter_id', 'chapter_id');
    }

    public function toEntity(): ChapterEntity
    {
        return new ChapterEntity($this);
    }
}
