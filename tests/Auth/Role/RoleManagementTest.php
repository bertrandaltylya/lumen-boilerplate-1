<?php
/**
 * Created by PhpStorm.
 * User: Lloric Mayuga Garcia <lloricode@gmail.com>
 * Date: 12/24/18
 * Time: 11:17 AM
 */

namespace Tests\Auth\Role;

class RoleManagementTest extends BaseRole
{
    /**
     * @param $routeName
     *
     * @test
     * @testWith ["store"]
     *          ["update"]
     */
    public function validationRole($routeName)
    {
        $this->loggedInAs();

        $route = "backend.role.$routeName";
        $paramNoData = [
            'name' => '',
        ];
        switch ($routeName) {
            case 'store':
                $this->post(route($route), $paramNoData);
                break;
            case 'update':
                $this->put(route($route, [
                    'id' => $this->createRole()->getHashedId(),
                ]), $paramNoData);
                break;
        }
        $this->assertResponseStatus(422);
        $this->seeJson([
            'name' => ['The name field is required.'],
        ]);
    }

    /**
     * @param $verbMethod
     * @param $routeName
     *
     * @test
     * @testWith ["delete", "backend.role.destroy"]
     *          ["put", "backend.role.update"]
     */
    public function defaultRoleNotAllowed($verbMethod, $routeName)
    {
        $this->loggedInAs();
        $this->{$verbMethod}(route($routeName, [
            'id' => $this->getByRoleName('system')->getHashedId(),
        ]));
        $this->assertResponseStatus(422);
        $this->seeJson([
            'message' => 'You cannot update/delete default role.',
        ]);
    }

    /**
     * @test
     */
    public function storeRoleSuccess()
    {
        $this->loggedInAs();

        $data = [
            'name' => 'test new role',
        ];
        $this->post(route('backend.role.store'), $data);

        $this->assertResponseStatus(201);
        $this->seeJson($data);
    }

    /**
     * @test
     */
    public function updateRoleSuccess()
    {
        $this->loggedInAs();
        $roleNameTest = 'im role name';

        $role = $this->createRole($roleNameTest);

        $data = [
            'name' => $roleNameTest . ' new',
        ];

        $this->put(route('backend.role.update', [
            'id' => $role->getHashedId(),
        ]), $data);

        $this->assertResponseStatus(200);
        $this->seeJson($data);
    }

    /**
     * @test
     */
    public function updateDuplicateRole()
    {
        $this->loggedInAs();
        $duplicateNameTest = 'im duplicate role name';

        $this->createRole($duplicateNameTest);

        $role = $this->createRole('another role name');

        $data = [
            'name' => $duplicateNameTest,
        ];

        $this->put(route('backend.role.update', [
            'id' => $role->getHashedId(),
        ]), $data);

        $this->assertResponseStatus(422);
        $this->seeJson([
            'message' => "A role `{$duplicateNameTest}` already exists for guard `api`.",
        ]);
    }

    /**
     * @test
     */
    public function storeDuplicateRole()
    {
        $this->loggedInAs();
        $roleNameTest = 'im duplicate role name';

        $this->createRole($roleNameTest);

        $data = [
            'name' => $roleNameTest,
        ];
        $this->post(route('backend.role.store'), $data);

        $this->assertResponseStatus(500); // TODO: fix status code to 422
        $this->seeJson([
            'message' => "A role `$roleNameTest` already exists for guard `api`.",
        ]);
    }
}