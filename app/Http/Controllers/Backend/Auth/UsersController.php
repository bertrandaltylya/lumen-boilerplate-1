<?php

namespace App\Http\Controllers\Backend\Auth;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\UserTransformer;

class UsersController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->model()::PERMISSIONS;

        $this->middleware('permission:'.$permissions['index'], ['only' => 'index']);

        $this->userRepository = $userRepository;
    }

    /**
     * @return \Spatie\Fractalistic\Fractal
     * @throws \ReflectionException
     */
    public function index()
    {
        return $this->transform($this->userRepository->paginate(), new UserTransformer);
    }
}
