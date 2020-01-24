<?php


namespace App\Actions\Posts;


use App\Repositories\PostRepository;
use Nicu\Actions\ApiAction;
use Nicu\Exceptions\NotFound;

class GetPost extends ApiAction
{
    /** @var PostRepository */
    private $postRepo;

    public function __construct(PostRepository $postRepository)
    {
        $this->postRepo = $postRepository;
    }

    protected function action(): array
    {
        $slug = $this->get('slug');
        $post = $this->postRepo->findOne($slug);
        if (!$post) {
            throw new NotFound();
        }
        return $post->toArray();
    }
}
