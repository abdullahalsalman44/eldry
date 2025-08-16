<?php

namespace App\Http\Controllers;

use App\Http\Requests\Eldery\CreateElderyRequest;
use App\Http\Requests\Eldery\GetElderyRequest;
use App\Http\Resources\ElderyCollection;
use App\Models\ElderlyPerson;
use App\services\ElderlyService;
use App\Traits\ResponseTrait;
use Illuminate\Http\Request;

class ElderlyPersonController extends Controller
{
    use ResponseTrait;

    public ElderlyService $elderlyPerson;
    public function __construct(ElderlyService $elderlyPerson)
    {
        $this->elderlyPerson = $elderlyPerson;
    }

    public function index(GetElderyRequest $request)
    {
        $elderies = $this->elderlyPerson->geAll($request->validated());
        $elderies = ElderyCollection::collection($elderies);
        return $this->paginateSuccessResponse($elderies);
    }

    public function create(CreateElderyRequest $request)
    {
        $this->elderlyPerson->create($request->validated());
        return $this->messageSuccessResponse('eldery created successfully');
    }

    public function update(Request $request, $id) {}


    public function show($id)
    {
        $eldery = $this->elderlyPerson->show($id);
        $eldery = new ElderyCollection($eldery);
        return $this->successResponse($eldery);
    }


    public function destroy($id) {}
}
