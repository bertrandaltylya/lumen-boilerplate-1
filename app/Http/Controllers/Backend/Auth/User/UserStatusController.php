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
use Illuminate\Http\Request;

class UserStatusController extends Controller
{
    protected $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $permissions = $userRepository->model()::PERMISSIONS;

        $this->middleware('permission:' . $permissions['restore'], ['only' => 'restore']);
        $this->middleware('permission:' . $permissions['purge'], ['only' => 'purge']);

        $this->userRepository = $userRepository;
    }

    /**
     * @param Request $request
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     */
    public function restore(Request $request)
    {
        $this->userRepository->restore($this->decodeId($request));
    }

    public function purge()
    {
        return $this->noContent();
    }
}