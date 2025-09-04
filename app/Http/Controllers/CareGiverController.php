<?php

namespace App\Http\Controllers;

use App\Helpers\ResponseHelper;
use App\Http\Requests\CareGiver\CreateCaregiverRequest;
use App\Http\Requests\User\UpdateInformationsRequest;
use App\Http\Resources\ElderyCollection;
use App\services\CareGiverService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class CareGiverController extends Controller
{
    use ResponseTrait;
    public CareGiverService $careGiverService;
    public function __construct(CareGiverService $careGiverService)
    {
        $this->careGiverService = $careGiverService;
    }

    public function create(CreateCaregiverRequest $request)
    {
        $careGiver = $this->careGiverService->create($request->validated());
        return ResponseHelper::success(data: $careGiver);
    }

    public function update(UpdateInformationsRequest $request)
    {
        $careGiver = $this->careGiverService->update($request->validated());
        return ResponseHelper::success(data: $careGiver);
    }

    public function getListOfEldries(Request $request)
    {
        $eldries = ElderyCollection::collection(
            $this->careGiverService->getListOfEldries(
                $request->page,
                $request->per_page,
            )
        );
        return $this->paginateSuccessResponse(data: $eldries);
    }
}
