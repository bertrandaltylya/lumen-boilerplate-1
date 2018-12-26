<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/16/18
 * Time: 11:28 AM
 */

namespace App\Repositories\Auth\Role;

use App\Criterion\Eloquent\ThisWhereEqualsCriteria;
use App\Repositories\BaseRepository;
use Prettus\Repository\Events\RepositoryEntityUpdated;
use Prettus\Validator\Contracts\ValidatorInterface;
use Spatie\Permission\Guard;

class RoleRepository extends BaseRepository
{
    /**
     * Specify Validator Rules
     *
     * @var array
     */
    protected $rules = [
        ValidatorInterface::RULE_CREATE => [
            'name' => 'required|string',
        ],
        ValidatorInterface::RULE_UPDATE => [
            'name' => 'required|string',
        ],
    ];

    /**
     * @param array $attributes
     * @param       $id
     *
     * @return mixed
     * @throws \Prettus\Repository\Exceptions\RepositoryException
     * @throws \Prettus\Validator\Exceptions\ValidatorException
     */
    public function update(array $attributes, $id)
    {
        $this->skipPresenter(true);

        $this->checkDefault($id);

        $attributes['name'] = isset($attributes['name']) ? $attributes['name'] : '';

        $guardName = Guard::getDefaultName($this->model());
        $this->pushCriteria(new ThisWhereEqualsCriteria('name', $attributes['name']));
        $this->pushCriteria(new ThisWhereEqualsCriteria('guard_name', $guardName));
        if ($this->first()) {
            abort(422, "A role `{$attributes['name']}` already exists for guard `$guardName`.");
        }

        return parent::update($attributes, $id);
    }

    /**
     * @param $id
     */
    private function checkDefault($id)
    {
        if (in_array($this->find($id)->name, config('access.role_names'))) {
            abort(422, 'You cannot update/delete default role.');
        }
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return config('permission.models.role');
    }

    public function delete($id)
    {
        $this->checkDefault($id);
        return parent::delete($id);
    }

    public function create(array $attributes)
    {
        $this->validate($attributes, ValidatorInterface::RULE_CREATE);

        $role = $this->model()::create($attributes);
        event(new RepositoryEntityUpdated($this, $role));
        return $this->parserResult($role);
    }

    private function validate(array $attributes, $rule)
    {
        $attributes = $this->model->newInstance()->forceFill($attributes)->makeVisible($this->model->getHidden())->toArray();
        $this->validator->with($attributes)->passesOrFail($rule);
    }
}