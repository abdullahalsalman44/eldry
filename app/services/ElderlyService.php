<?php

namespace App\services;

use App\Exceptions\NotFoundException;
use App\Models\ElderlyPerson;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;

class ElderlyService
{

    public function geAll(array $data)
    {
        $user = User::query()->find(Auth::user()->id);
        $query = ElderlyPerson::with('room');

        if ($user->hasRole('caregiver')) {
            $query = $query->where('caregiver_id', $user->id);
        }

        if (array_key_exists('full_name', $data)) {
            $query->where('full_name', 'like', '%' . $data['full_name'] . '%');
        }

        if (array_key_exists('date_of_birth', $data)) {
            $query->where('date_of_birth', $data['date_of_birth']);
        }

        if (array_key_exists('gender', $data)) {
            $query->where('gender', $data['gender']);
        }

        if (array_key_exists('room_id', $data)) {
            $query->where('room_id', $data['room_id']);
        }

        if (array_key_exists('login_at', $data)) {
            $query->where('login_at', $data['login_at']);
        }

        if (array_key_exists('caregivr', $data) && $user->hasRole('admin')) {
            $query->where('caregiver_id', $data['caregivr']);
        }

        $eldeirs = $query->paginate(10);

        return $eldeirs;
    }

    public function create(array $data)
    {
        if (array_key_exists('image', $data) && is_file($data['image'])) {
            $path = upload_file($data['image'], 'Eldery');
            $data['image'] = $path;
        }

        $eldery = ElderlyPerson::query()->create($data);

        return $eldery;
    }

    public function show($id)
    {
        $eldery = ElderlyPerson::query()
            ->with('room')
            ->find($id);

        if ($eldery == null) {
            throw new NotFoundException('Eldery Not Found');
        }

        return $eldery;
    }

    public function update(array $data, $id)
    {
        $eldery = ElderlyPerson::query()->find($id);

        if ($eldery == null) {
            throw new NotFoundException('Eldery Not Found', 404);
        }

        if (array_key_exists('image', $data)) {
            if ($eldery->image != null && Storage::exists($eldery->image)) {
                Storage::delete($eldery->image);
            }
            $data['image'] = upload_file($data['image'], 'Eldery');
        }

        $eldery->update($data);

        return true;
    }

    public function delete($id)
    {
        $eldery = ElderlyPerson::query()->find($id);

        if ($eldery == null) {
            throw new NotFoundException('Eldery Not Found');
        }

        $eldery->delete();

        return true;
    }
}
