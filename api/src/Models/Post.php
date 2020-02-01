<?php


namespace App\Models;


use DateTime;
use stdClass;

class Post implements ModelInterface
{
    const READ_MORE_PLACEHOLDER = '§§§';
    const FALLBACK_TRIM = 500;
    public $slug;
    public $title;
    public $body;
    public $tags;
    /** @var DateTime */
    public $publishedDate;

    public function __construct(string $slug, string $title, string $body, DateTime $publishedDate, ?string $tags = null)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->body = $body;
        $this->tags = $tags;
        $this->publishedDate = $publishedDate;
    }

    public static function fromStdClass(stdClass $row, bool $trim = false)
    {
        $body = $trim ? self::trim($row->body) : self::clearBody($row->body);

        return new self(
            $row->slug,
            $row->title,
            $body,
            new DateTime($row->publishedDate),
            $row->tags
        );
    }

    public static function fromArray(array $rows)
    {
        $posts = [];
        foreach ($rows as $row) {
            $post = self::fromStdClass($row, true);
            $posts[] = $post->toArray();
        }

        return $posts;
    }

    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'body' => $this->body,
            'publishedDate' => $this->publishedDate->format('Y-m-d H:i:s'),
            'tags' => $this->tags,
        ];
    }

    private static function trim(string $body)
    {
        if (strpos($body, self::READ_MORE_PLACEHOLDER)) {
            return substr($body, 0, strpos($body, self::READ_MORE_PLACEHOLDER)) . '...';
        }

        return substr($body, 0, self::FALLBACK_TRIM) . '...';
    }

    private static function clearBody(string $body)
    {
        return str_replace(self::READ_MORE_PLACEHOLDER, '', $body);
    }
}
