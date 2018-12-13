<?php

namespace App\Http\Controllers\Backend\Auth\User;

use App\Criterion\Eloquent\ThisWhereEqualsCriteria;
use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Transformers\UserTransformer;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Class UserController
 *
 * @package App\Http\Controllers\Backend\Auth\User
 * @group   User Management
 */
class UserController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $permissions = app($userRepository->model())::PERMISSIONS;

        $this->middleware('permission:' . $permissions['index'], ['only' => 'index']);
        $this->middleware('permission:' . $permissions['create'], ['only' => 'store']);
        $this->middleware('permission:' . $permissions['show'], ['only' => 'show']);
        $this->middleware('permission:' . $permissions['update'], ['only' => 'update']);
        $this->middleware('permission:' . $permissions['destroy'], ['only' => 'destroy']);

        $this->userRepository = $userRepository;
    }

    /**
     * Get all users.
     *
     * @param Request $request
     *
     * @return \Spatie\Fractalistic\Fractal
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @authenticated
     * @responseFile responses/users.get.json
     */
    public function index(Request $request)
    {
        $this->userRepository->pushCriteria(new RequestCriteria($request));

        return $this->transform($this->userRepository->paginate(), new UserTransformer);
    }

    /**
     * Show user.
     *
     * @param Request $request
     *
     * @return \Spatie\Fractalistic\Fractal
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @authenticated
     * @responseFile responses/user.get.json
     */
    public function show(Request $request)
    {
        $this->userRepository->pushCriteria(new ThisWhereEqualsCriteria('id', $this->decodeId($request)));

        $user = $this->userRepository->first();
        if (is_null($user)) {
            throw new ModelNotFoundException;
        }

        return $this->transform($user, new UserTransformer);
    }

    /**
     * Store user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @authenticated
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @bodyParam    first_name string required First name. Example: Lloric
     * @bodyParam    last_name string required Last name. Example: Garcia
     * @bodyParam    email string required A valid email and unique. Example: lloricode@gmail.com
     * @bodyParam    password string required Password Example: secret
     * @responseFile 201 responses/user.get.json
     */
    public function store(Request $request)
    {
        return $this->created($this->transform($this->userRepository->create($request->all()), new UserTransformer));
    }

    /**
     * Update user.
     *
     * @param Request $request
     *
     * @return \Spatie\Fractalistic\Fractal
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @authenticated
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     * @bodyParam    first_name string First name. Example: Lloric
     * @bodyParam    last_name string Last name. Example: Garcia
     * @bodyParam    email string A valid email and unique. Example: lloricode@gmail.com
     * @bodyParam    password string Password Example: secret
     * @responseFile responses/user.get.json
     */
    public function update(Request $request)
    {
        $user = $this->userRepository->update($request->only([
            'first_name',
            'last_name',
            'email',
            'password',
        ]), $this->decodeId($request));

        return $this->transform($user, new UserTransformer);
    }

    /**
     * Destroy user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @authenticated
     * @responseFile 204 responses/no-content.get.json
     */
    public function destroy(Request $request)
    {
        $this->userRepository->delete($this->decodeId($request));
        return $this->noContent();
    }
}
