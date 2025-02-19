<?php

namespace App\Http\Controllers;

use App\Http\Requests\Date\StoreRequest;
use App\Http\Requests\Date\UpdateRequest;
use App\Http\Resources\DateResource;
use App\Models\Date;
use Illuminate\Http\Request;

class DateController extends Controller
{
    public function index()
    {
        $dates = Date::all();
        return DateResource::collection($dates);
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $date = Date::create($data);

        return DateResource::make($date);
    }

    public function show(Date $date)
    {
        return DateResource::make($date);
    }

    public function update(UpdateRequest $request, Date $date)
    {
        $data = $request->validated();
        $date->update($data);

        return DateResource::make($date->refresh());
    }

    public function destroy(Date $date)
    {
        $date->delete();

        return response()->noContent();
    }
}
