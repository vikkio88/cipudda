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
        $this->table = $database->table('posts');
    }

    public function getAll(): array
    {
        /** @var array $posts */
        $posts = $this->table->get();
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
        $this->database->insert($postBody);
    }
}
