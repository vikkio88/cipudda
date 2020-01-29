<?php


namespace App\Actions\Admin;


use App\Repositories\PostRepository;
use Nicu\Actions\ApiAction;

class UpdatePost extends ApiAction
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
        $this->postRepo->update($slug, $this->getRequestBody());
        return ['status' => 'ok'];
    }
}
