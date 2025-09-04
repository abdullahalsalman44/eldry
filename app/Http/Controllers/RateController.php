<?php

namespace App\Http\Controllers;

use App\Models\Rate;
use Illuminate\Http\Request;
use App\Traits\ResponseTrait;
use Illuminate\Support\Facades\Log;
use App\Http\Requests\Rate\CreateRateRequest;
use App\Http\Resources\RateResource;
use Illuminate\Support\Facades\Auth;
use Termwind\Components\Raw;

class RateController extends Controller
{
    use ResponseTrait;

    public function index(Request $request)
    {
        $user = Auth::user();
        if ($user && $user->hasRole('admin')) {
            if ($request->has('employee_id'))
                $rates = Rate::query()->where('employee_id', $request->employee_id);
            else
                $rates = Rate::query();
        } elseif ($user != null) {
            $rates = Rate::query()->where('employee_id', $user->id);
        } else {
            $rates = Rate::query();
        }
        $rates = $rates->paginate($request->per_page);
        $rates->load('employee');
        $rates = RateResource::collection($rates);
        return $this->paginateSuccessResponse($rates);
    }

    public function store(CreateRateRequest $request)
    {
        try {
            $data = $request->validated();
            Rate::query()->create([
                'employee_id' => (int) $data['employee_id'],
                'name' => $data['user_name'],
                'note' => $data['note'],
                'rate' => $data['rate'],
            ]);
            return $this->messageSuccessResponse();
        } catch (\Throwable $e) {
            Log::info($e->getMessage() . ' file ' . $e->getFile() . ' line ' . $e->getLine());
            return $this->messageErrorResponse();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
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
    public function destroy() {}
}
