<?php

namespace App\Http\Controllers;

use App\Repositories\User\UserRepository;
use App\Transformers\UserTransformer;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function index()
    {
        return fractal($this->userRepository->paginate(), new UserTransformer())->respond();
    }
}
