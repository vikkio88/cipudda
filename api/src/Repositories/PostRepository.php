<?php


namespace App\Repositories;


use App\Exceptions\NotFound;
use App\Models\Post;
use App\Models\PostListItem;
use Pixie\QueryBuilder\QueryBuilderHandler;


class PostRepository
{
    /** @var QueryBuilderHandler */
    private $database;
    /** @var QueryBuilderHandler */
    private $table;

    public function __construct(QueryBuilderHandler $database)
    {
        $this->database = $database;
        /** @noinspection PhpParamsInspection */
        $this->table = $database->table('posts');
    }

    public function getAll(): array
    {
        /** @var array $posts */
        $posts = $this->table->orderBy('publishedDate', 'DESC')->get();
        if (!count($posts)) {
            return [];
        }
        return Post::fromArray($posts);
    }

    public function findOne($slug): ?Post
    {
        /** @var array $posts */
        $posts = $this->table->where('slug', $slug)->get();
        if (!$posts || count($posts) < 1) {
            throw new NotFound();
        }
        return Post::fromStdClass($posts[0]);
    }

    public function create(array $postBody)
    {
        return $this->table->insert($postBody);
    }

    public function update(string $slug, array $postBody)
    {
        if ($postBody['slug'] === $slug) {
            unset($postBody['slug']);
        }

        return $this->table->where('slug', $slug)->update($postBody);
    }

    public function getByTag($tag)
    {
        /** @var array $posts */
        $posts = $this->table->where('tags', 'LIKE', "%$tag%")->get();
        return Post::fromArray($posts);
    }

    public function getAllTitle(): array
    {
        /** @var array $posts */
        $posts = $this->table->select('slug', 'title', 'publishedDate')->orderBy('publishedDate', 'DESC')->get();
        return PostListItem::fromArray($posts);
    }

    public function delete(string $slug)
    {
        $this->table->where('slug', $slug)->delete();
    }
}
