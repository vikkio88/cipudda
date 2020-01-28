<?php


namespace App\Actions\Admin;


use App\Repositories\PostRepository;
use Nicu\Actions\ApiAction;
use Nicu\Exceptions\ValidationError;
use Throwable;

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
        try {
            $this->postRepo->create($this->getRequestBody());
        } catch (Throwable $exception) {
            throw new ValidationError();
        }
        return ['status' => 'ok'];
    }
}
