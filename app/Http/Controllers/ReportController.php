<?php

namespace App\Http\Controllers;

use App\Http\Requests\Report\CreateReportRequest;
use App\Http\Resources\ReportResource;
use App\Http\Resources\UserResource;
use App\Models\ElderlyPerson;
use App\Models\Report;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ReportController extends Controller
{
    use ResponseTrait;
    public function index(Request $request)
    {
        $user = Auth::user();
        $report = null;
        if ($user->hasRole('family')) {
            $eldery = $user->elderlies->first();
            $report = Report::query()
                ->with(['eldery'])
                ->where('eldery_id', $eldery->id)
                ->orderBy('created_at', 'desc')
                ->first();
            return $this->successResponse(new ReportResource($report));
        }

        if ($user->hasRole('admin')) {
            $report =  Report::query()
                ->with(['eldery', 'caregiver'])
                ->when($request->eldery_id, function ($query) use ($request) {
                    $query->where('eldery_id', $request->eldery_id);
                })
                ->when($request->from_date, function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
                })
                ->paginate($request->per_page);
        }

        if ($user->hasRole('caregiver')) {
            $report = Report::query()
                ->with(['eldery'])
                ->when($request->eldery_id, function ($query) use ($request) {
                    $query->where('eldery_id', $request->eldery_id);
                })
                ->when($request->from_date, function ($query) use ($request) {
                    $query->whereBetween('created_at', [$request->from_date, $request->to_date]);
                })
                ->where('caregiver_id', $user->id)
                ->paginate($request->per_page);
        }

        if ($report) {
            return $this->paginateSuccessResponse(
                ReportResource::collection($report),
            );
        }
        return $this->successResponse([], 'No Reports');
    }

    public function store(CreateReportRequest $request)
    {
        $user = Auth::user();
        $data = $request->validated();
        $data['caregiver_id'] = $user->id;
        Report::query()->create($data);
        return $this->messageSuccessResponse();
    }

    public function show(string $id)
    {
        //
    }

    public function update(Request $request, string $id)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
