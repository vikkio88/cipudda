<?php


namespace App\Actions\Posts;


use App\Actions\ApiAction;
use App\Repositories\PostRepository;

class GetPosts extends ApiAction
{
    /** @var PostRepository */
    private $postRepo;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepo = $postRepository;
    }

    protected function action(): array
    {
        return $this->postRepo->getAll();
    }
}
