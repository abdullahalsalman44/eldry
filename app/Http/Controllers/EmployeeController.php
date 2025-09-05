<?php

namespace App\Http\Controllers;

use App\Http\Resources\UserResource;
use App\Models\User;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class EmployeeController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $employees = User::query()
            ->with(['rates'])
            ->when($request->role, function ($query) use ($request) {
                $query->where('role', $request->role);
            })
            ->when($request->search, function ($query) use ($request) {
                $query->where('name', 'like', "%$request->search%");
            })
            ->whereNot('role', 'family')
            ->whereNot('role', 'admin')
            ->paginate($request->per_page);

        return $this->paginateSuccessResponse(UserResource::collection($employees));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        $employee = User::query()->findOrFail($id);
        return $this->successResponse(
            new UserResource($employee)
        );
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
