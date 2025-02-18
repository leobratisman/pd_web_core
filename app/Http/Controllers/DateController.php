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
        return DateResource::collection($dates)->resolve();
    }

    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $date = Date::create($data);

        return DateResource::make($date)->resolve();
    }

    public function show(Date $date)
    {
        return DateResource::make($date)->resolve();
    }

    public function update(UpdateRequest $request, Date $date)
    {
        $data = $request->validated();
        $date->update($data);
        $date->fresh();

        return DateResource::make($date)->resolve();
    }

    public function destroy(Date $date)
    {
        Date::delete($date);

        return response()->json([
           'message' => 'date was deleted!'
        ]);
    }
}
