<?php

namespace App\services;

use App\Exceptions\NoResourcesException;
use App\Models\ElderlyPerson;
use App\Models\User;
use App\Repository\BaseRepository;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Spatie\Permission\Models\Role;

class CareGiverService
{
    public BaseRepository $baseRepository;
    public function __construct(BaseRepository $baseRepository)
    {
        $this->baseRepository = $baseRepository;
    }

    public function create($data)
    {
        try {
            DB::beginTransaction();
            $data['password'] = Hash::make($data['password']);
            $careGiver = User::query()->create($data);

            if (!$careGiver) {
                throw new Exception('faild to create caregiver', 500);
            }
            $token = $careGiver->createToken('api-token')->plainTextToken;


            $role = Role::query()->where('name', 'caregiver')->first();
            $permissions = $role->permissions()->pluck('name')->toArray();
            $careGiver->assignRole($role);
            $careGiver->givePermissionTo($permissions);

            $careGiver->load('roles');
            $this->append_roles($careGiver);

            DB::commit();
            return ['care' => $careGiver, 'token' => $token];
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function update(array $data)
    {
        try {
            DB::beginTransaction();
            $user = Auth::user();
            $user = User::query()->find($user->id);
            if (!$user) {
                throw new Exception('user not exists', 404);
            }

            if (array_key_exists('image', $data)) {
                if ($user->image != null) {
                    File::delete('storage/' . $user->image);
                }
                $data['image'] = upload_file($data['image'], 'caregievers');
            }

            $user->update($data);

            $user = $user->fresh();

            $user->load('roles');

            $this->append_roles($user);

            DB::commit();

            return $user;
        } catch (\Throwable $e) {
            DB::rollBack();
            throw new Exception($e->getMessage());
        }
    }

    public function getListOfEldries($page, $per_page)
    {
        $user = Auth::user();
        $eldries = ElderlyPerson::query()->where('caregiver_id', $user->id)->paginate($per_page);
        return $eldries;
    }


    function append_roles($user)
    {
        $roles = [];
        foreach ($user->roles as $role) {
            $roles = $role->name;
        }
        unset($user['roles']);
        $user['roles'] = $roles;
        return $user;
    }
}
