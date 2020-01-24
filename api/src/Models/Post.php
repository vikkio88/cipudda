<?php


namespace App\Models;


use DateTime;
use stdClass;

class Post implements ModelInterface
{
    public $slug;
    public $title;
    public $body;
    public $tags;
    /** @var DateTime */
    public $publishedDate;

    public function __construct(string $slug, string $title, string $body, DateTime $publishedDate, ?array $tags = [])
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->body = $body;
        $this->tags = $tags;
        $this->publishedDate = $publishedDate;
    }

    public static function fromStdClass(stdClass $row)
    {
        return new self(
            $row->slug,
            $row->title,
            $row->body,
            new DateTime($row->publishedDate),
            $row->tags
        );
    }

    public static function fromArray(array $rows)
    {
        $posts = [];
        foreach ($rows as $row) {
            $post = self::fromStdClass($row);
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
}
