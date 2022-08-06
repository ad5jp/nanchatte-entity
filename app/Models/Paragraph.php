<?php

namespace App\Models;

use App\Entities\Paragraph as ParagraphEntity;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

/**
 * @property int $paragraph_id
 * @property int $chapter_id
 * @property string $chapter_title
 * @property int $sequence
 * @property int $start_page
 * @property Carbon $created_at
 * @property Carbon $updated_at
 * @mixin \Eloquent
 */
class Paragraph extends Model
{
    protected $table = "m_paragraphs";
    protected $primaryKey = 'paragraph_id';

    protected $dates = [
        'created_at',
		'updated_at',
    ];

    protected $casts = [
        'paragraph_id' => 'integer',
		'chapter_id' => 'integer',
		'sequence' => 'integer',
		'start_page' => 'integer',
		'created_at' => 'date:Y-m-d H:i:s',
		'updated_at' => 'date:Y-m-d H:i:s',
    ];

    public function chapter() : BelongsTo
    {
        return $this->belongsTo(Chapter::class, 'chapter_id', 'chapter_id');
    }

    public function toEntity(): ParagraphEntity
    {
        return new ParagraphEntity($this);
    }
}
