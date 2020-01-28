<?php


namespace App\Models;

use DateTime;
use stdClass;

class PostListItem implements ModelInterface
{
    public $slug;
    public $title;
    /** @var DateTime */
    public $publishedDate;

    public function __construct(string $slug, string $title, DateTime $publishedDate)
    {
        $this->slug = $slug;
        $this->title = $title;
        $this->publishedDate = $publishedDate;
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

    public static function fromStdClass(stdClass $row): self
    {
        return new self(
            $row->slug,
            $row->title,
            new DateTime($row->publishedDate)
        );
    }


    public function toArray(): array
    {
        return [
            'slug' => $this->slug,
            'title' => $this->title,
            'publishedDate' => $this->publishedDate->format('Y-m-d H:i:s'),
        ];
    }
}
