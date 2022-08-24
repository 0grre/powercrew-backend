<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\TeamResource;
use App\Models\Team;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Validator;

class TeamController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return JsonResponse
     */
    public function index(): JsonResponse
    {
        return $this->sendResponse(Team::all(), 'Teams found successfully.');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     * @return JsonResponse
     */
    public function store(Request $request): JsonResponse
    {
        return $this->sendResponse($this->TeamValidator($request), 'Team created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param $id
     * @return JsonResponse
     */
    public function show($id): JsonResponse
    {
        $team = Team::find($id);

        if (is_null($team)) {
            return $this->sendError('Team not found.');
        }

        if (!self::check_owner($team)) {
            return $this->sendError('Team is not accessible');
        }

        return $this->sendResponse(TeamResource::make($team), 'Team found successfully . ');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param $id
     * @return JsonResponse
     */
    public function update(Request $request, $id): JsonResponse
    {
        $team = Team::find($id);

        if (is_null($team)) {
            return $this->sendError('Team not found . ');
        }

        if (self::check_owner($team)) {
            return $this->sendResponse($this->TeamValidator($request, $id), 'Team updated successfully.');
        } else {
            return $this->sendError('Validation Error . ', (array)'this resource does not belong to you');
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Team $history
     * @return Response
     */
    public function destroy(Team $history)
    {
        //
    }

    /**
     * @param $team
     * @return bool
     */
    public function check_owner($team): bool
    {
        if (Auth::user()->hasRole(['customer', 'vip', 'ambassador'])) {
            if ($team->user_id != Auth::user()->getAuthIdentifier()) {
                return false;
            } else {
                return true;
            }
        } else {
            return true;
        }
    }

    /**
     * @param Request $request
     * @param $id
     * @return JsonResponse|TeamResource
     */
    public function TeamValidator(Request $request, $id = null): JsonResponse|TeamResource
    {

        $team = $id ? Team::find($id) : new Team();

        if (is_null($team)) {
            return $this->sendError('Team not found . ');
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required | string',
            'user_id' => 'required',
        ]);

        if ($validator->fails()) {
            return $this->sendError('Validation Error.', (array)$validator->errors());
        }

        return TeamResource::make($team);
    }
}
