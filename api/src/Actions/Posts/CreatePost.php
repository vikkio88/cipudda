<?php


namespace App\Actions\Posts;


use App\Repositories\PostRepository;
use Nicu\Actions\ApiAction;
use Nicu\Exceptions\NotFound;

class CreatePost extends ApiAction
{
    /** @var PostRepository */
    private $postRepo;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepo = $postRepository;
    }

    protected function action(): array
    {
        $this->postRepo->create($this->getRequestBody());
        return ['status' => 'ok'];
    }
}
