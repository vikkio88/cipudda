<?php


namespace App\Actions\Admin;


use App\Actions\ApiAction;
use App\Exceptions\NotFound;
use App\Repositories\PostRepository;

class DeletePost extends ApiAction
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
        if (!$slug) {
            throw new NotFound();
        }

        $this->postRepo->delete($slug);
        return ['status' => 'ok'];
    }
}
