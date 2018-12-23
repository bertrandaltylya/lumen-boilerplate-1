<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/2/18
 * Time: 4:08 PM
 */

namespace App\Http\Controllers\Backend\Auth\User;

use App\Http\Controllers\Controller;
use App\Repositories\Auth\User\UserRepository;
use App\Repositories\Presenters\Auth\UserPresenter;
use Illuminate\Http\Request;

/**
 * Class UserDeleteController
 *
 * @package App\Http\Controllers\Backend\Auth\User
 * @group   User Management
 */
class UserDeleteController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $permissions = app($userRepository->model())::PERMISSIONS;

        $this->middleware('permission:' . $permissions['restore'], ['only' => 'restore']);
        $this->middleware('permission:' . $permissions['purge'], ['only' => 'purge']);

        $this->userRepository = $userRepository;
    }

    /**
     * Restore user.
     *
     * @param \Illuminate\Http\Request $request
     *
     * @return mixed
     * @authenticated
     * @responseFile responses/auth/user.get.json
     */
    public function restore(Request $request)
    {
        $this->userRepository->setPresenter(UserPresenter::class);
        return $this->userRepository->restore($this->decodeId($request));
    }

    /**
     * Purge user.
     *
     * @param Request $request
     *
     * @return \Illuminate\Http\JsonResponse
     * @authenticated
     * @responseFile 204 responses/no-content.get.json
     */
    public function purge(Request $request)
    {
        $this->userRepository->forceDelete($this->decodeId($request));
        return $this->noContent();
    }
}