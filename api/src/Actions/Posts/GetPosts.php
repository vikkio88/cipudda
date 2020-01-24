<?php


namespace App\Actions\Posts;


use App\Repositories\PostRepository;
use Nicu\Actions\ApiAction;

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
