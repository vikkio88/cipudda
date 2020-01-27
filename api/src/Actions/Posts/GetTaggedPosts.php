<?php


namespace App\Actions\Posts;


use App\Repositories\PostRepository;
use Nicu\Actions\ApiAction;

class GetTaggedPosts extends ApiAction
{
    /** @var PostRepository */
    private $postRepo;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepo = $postRepository;
    }

    protected function action(): array
    {
        $tag = $this->get('tag', null);
        if (!$tag) {
            return [];
        }

        return $this->postRepo->getByTag($tag);
    }
}
