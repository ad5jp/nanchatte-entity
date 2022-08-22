<?php

declare(strict_types=1);

namespace App\Domain\Book;

use App\Enums\Arg;
use App\Models\Book as BookRecord;
use App\Models\Chapter as ChapterRecord;
use App\Models\Paragraph as ParagraphRecord;
use Carbon\CarbonImmutable;

class BookRepository
{
    public function retrieveByIdWith(BookId $id): ?Book
    {
        return BookRecord::query()
            ->with([
                'chapters',
                'chapters.paragraphs',
            ])
            ->whereKey($id->value())
            ->first()
            ?->toEntity();
    }

    public function create(
        string $bookTitle,
        string $authorName,
        int $totalPages,
        CarbonImmutable $publishDate,
    ): Book {
        return BookRecord::query()
            ->forceCreate([
                'book_title' => $bookTitle,
                'author_name' => $authorName,
                'total_pages' => $totalPages,
                'published_date' => $publishDate,
            ])
            ->toEntity();
    }

    public function addChapter(
        BookId $bookId,
        string $chapterTitle,
        int $startPage,
        int $sequence,
    ): Chapter {
        return ChapterRecord::query()
            ->forceCreate([
                'book_id' => $bookId->value(),
                'chapter_title' => $chapterTitle,
                'start_page' => $startPage,
                'sequence' => $sequence,
            ])
            ->toEntity();

    }

    public function addParagraph(
        ChapterId $chapterId,
        string $content,
        int $startPage,
        int $sequence,
    ): Paragraph {
        return ParagraphRecord::query()
            ->forceCreate([
                'chapter_id' => $chapterId->value(),
                'content' => $content,
                'start_page' => $startPage,
                'sequence' => $sequence,
            ])
            ->toEntity();
    }

    public function updateOrCreate(
        BookId $bookId,
        string|Arg $bookTitle = Arg::Identity,
        string|Arg $authorName = Arg::Identity,
        int|Arg $totalPages = Arg::Identity,
        CarbonImmutable|Arg $publishDate = Arg::Identity,
    ): Book {
        $updated = [];

        if ($bookTitle !== Arg::Identity) {
            $updated['book_title'] = $bookTitle;
        }
        if ($authorName !== Arg::Identity) {
            $updated['author_name'] = $authorName;
        }
        if ($totalPages !== Arg::Identity) {
            $updated['total_pages'] = $totalPages;
        }
        if ($publishDate !== Arg::Identity) {
            $updated['published_date'] = $publishDate;
        }

        return BookRecord::query()
            ->updateOrCreate([
                'book_id' => $bookId->value()
            ], $updated)
            ->toEntity();
    }

    public function updateChapter(
        ChapterId $chapterId,
        string|Arg $chapterTitle = Arg::Identity,
        int|Arg $startPage = Arg::Identity,
        int|Arg $sequence = Arg::Identity,
    ): Chapter {
        $updated = [];

        if ($chapterTitle !== Arg::Identity) {
            $updated['chapter_title'] = $chapterTitle;
        }
        if ($startPage !== Arg::Identity) {
            $updated['start_page'] = $startPage;
        }
        if ($sequence !== Arg::Identity) {
            $updated['sequence'] = $sequence;
        }

        return ChapterRecord::query()
            ->updateOrCreate([
                'chapter_id' => $chapterId->value()
            ], $updated)
            ->toEntity();
    }

    public function updateParagraph(
        ParagraphId $paragraphId,
        string|Arg $content = Arg::Identity,
        int|Arg $startPage = Arg::Identity,
        int|Arg $sequence = Arg::Identity,
    ): Paragraph {
        $updated = [];

        if ($content !== Arg::Identity) {
            $updated['content'] = $content;
        }
        if ($startPage !== Arg::Identity) {
            $updated['start_page'] = $startPage;
        }
        if ($sequence !== Arg::Identity) {
            $updated['sequence'] = $sequence;
        }

        return ParagraphRecord::query()
            ->updateOrCreate([
                'paragraph_id' => $paragraphId->value()
            ], $updated)
            ->toEntity();
    }
}
