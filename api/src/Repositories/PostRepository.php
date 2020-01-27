<?php


namespace App\Repositories;


use App\Models\Post;
use Nicu\Exceptions\NotFound;
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

    public function getByTag($tag)
    {
        /** @var array $posts */
        $posts = $this->table->where('tags', 'LIKE', "%$tag%")->get();
        return Post::fromArray($posts);
    }
}
