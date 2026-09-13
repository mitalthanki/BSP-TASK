<?php

namespace App\Http\Controllers;

use App\Models\Country;
use App\Models\State;
use Illuminate\Http\JsonResponse;

class LocationController extends Controller
{
    public function states(Country $country): JsonResponse
    {
        return response()->json(
            $country->states()->orderBy('name')->get(['id', 'name'])
        );
    }

    public function cities(State $state): JsonResponse
    {
        return response()->json(
            $state->cities()->orderBy('name')->get(['id', 'name'])
        );
    }
}
