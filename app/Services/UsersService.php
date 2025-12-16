<?php

namespace App\Services;

use App\Models\User;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Facades\Hash;

class UsersService
{
    public function getList(Array|Null $filters)
    {
        $users = User::select('id', 'name', 'email', 'created_at');
        $users = $this->filterList($users, $filters);
        return $users->orderBy('created_at', 'desc')->paginate(10);
    }

    public function getUsersList()
    {
        return User::select('id', 'name', 'email')->orderBy('created_at', 'desc')->get();
    }

    private function filterList(Builder $list, Array|Null $filters)
    {
        if(isset($filters["name"]))
        {
            $list->where("name", 'like', '%' . $filters["name"] . '%');
        }
        if(isset($filters["email"]))
        {
            $list->where("email", 'like', '%' . $filters["email"] . '%');
        }
        return $list;
    }

    public function getUserById(int $id)
    {
        return User::find($id);
    }

    public function createUser(string $email)
    {
        return User::create([
            'name' => 'User',
            'email' => $email,
            'password' => Hash::make('finanz456'),
            'role' => 'user',
            'is_first_login' => true
        ]);
    }

    public function editUser(int $id, string $name, string $email, string|null $password = null)
    {
        $user = $this->getUserById($id);

        if (is_null($user)) {
            return [
                'errors' => 'Failed to retrieve User',
                'http' => 404
            ];
        }

        $data = [
            'name' => $name,
            'email' => $email,
        ];

        if (!is_null($password) && $password !== '') {
            $data['password'] = Hash::make($password);
        }

        $user->update($data);
        return $user;
    }

    public function deleteUser(int $id)
    {
        $user = $this->getUserById($id);

        if (is_null($user)) {
            return [
                'errors' => 'User not found',
                'http' => 404
            ];
        }

        $user->delete();
        return ['success' => true];
    }

    public function updatePassword(int $userId, string $currentPassword, string $newPassword)
    {
        $user = $this->getUserById($userId);

        if (is_null($user)) {
            return [
                'errors' => 'User not found',
                'http' => 404
            ];
        }

        if (!Hash::check($currentPassword, $user->password)) {
            return [
                'errors' => 'Current password is incorrect',
                'http' => 401
            ];
        }

        $user->update([
            'password' => Hash::make($newPassword),
            'is_first_login' => false
        ]);

        return ['success' => true, 'message' => 'Password updated successfully'];
    }

    public function updateSettings(int $userId, string $language, string $currency)
    {
        $user = $this->getUserById($userId);

        if (is_null($user)) {
            return [
                'errors' => 'User not found',
                'http' => 404
            ];
        }

        $user->update([
            'language' => $language,
            'currency' => $currency
        ]);

        return ['success' => true, 'user' => $user];
    }
}
