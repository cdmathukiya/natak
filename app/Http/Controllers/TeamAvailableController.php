<?php

namespace App\Http\Controllers;

use App\Http\Requests\CreateSpotsItemRequest;
use App\Http\Requests\TeamAvailableRequest;
use App\Models\Team;
use App\Models\TeamAvailable;
use App\Models\TeamAvailableMember;
use App\Models\TeamSpots;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class TeamAvailableController extends Controller
{
    public function index(Request $request): Response
    {
        $user = Auth::user();

        $query = TeamAvailable::query()
            ->select('team_availables.*', DB::raw('CASE WHEN `date` > CURDATE() THEN true ELSE false END AS is_editable'))
            ->with('team');

        if (! $user->isAdmin()) {
            $query->whereRelation('team.user', 'id', '=', $user->id);
        }

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereRelation('team', 'name', 'LIKE', "%$search%");
            if (preg_match('/^\d{1,2}\/\d{1,2}\/\d{4}$/', $search)) {
                $date = Carbon::createFromFormat('d/m/Y', $search)->format('Y-m-d');
                $query->orWhereDate('date', $date);
            } elseif (preg_match('/^\d{1,2}\/\d{1,2}$/', $search)) {
                $date = Carbon::createFromFormat('d/m', $search);
                $query->orWhereMonth('date', $date->format('m'))
                    ->orWhereDay('date', $date->format('d'));
            } elseif (preg_match('/^\d{1,2}$/', $search)) {
                $date = Carbon::createFromFormat('d', $search);
                $query->orWhereDay('date', $date);
            }
        }

        $teamAvailables = $query->latest()->paginate(25)->withQueryString();

        return Inertia::render('TeamAvailable/Index', [
            'teamAvailables' => $teamAvailables,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        $user = Auth::user();

        $teams = Team::query();
        if (! $user->isAdmin()) {
            $teams->whereRelation('user', 'id', '=', $user->id);
        }
        $teams = $teams->get()->pluck('name', 'id');

        return Inertia::render('TeamAvailable/Create', [
            'teams' => $teams,
        ]);
    }

    public function getTeamDetails(Request $request): JsonResponse
    {
        $teamId = $request->get('team_id');
        $team = Team::query()
            ->with(['members:id as member_id,team_id,name,role', 'user'])
            ->find($teamId);

        return response()->json($team);
    }

    public function save(TeamAvailableRequest $request): RedirectResponse
    {
        $inputs = $request->validated();
        $members = $inputs['members'];
        unset($inputs['members']);
        $teamAvailable = TeamAvailable::create($inputs);

        foreach ($members as $key => $value) {
            $members[$key]['team_available_id'] = $teamAvailable->id;
            $members[$key]['created_at'] = now();
            $members[$key]['updated_at'] = now();
            if (! isset($members[$key]['is_available'])) {
                $members[$key]['is_available'] = false;
            }
        }

        TeamAvailableMember::insert($members);

        return redirect()->route('team_available.show', $teamAvailable->id)->with('success', 'Data saved successfully');
    }

    public function show(TeamAvailable $teamAvailable): Response
    {
        $teamAvailable->load(['team.user', 'members', 'spots']);

        return Inertia::render('TeamAvailable/Show', [
            'teamAvailable' => $teamAvailable,
        ]);
    }

    public function edit(TeamAvailable $teamAvailable): Response
    {
        $teamAvailable->load(['team.user', 'members', 'spots']);

        return Inertia::render('TeamAvailable/Create', [
            'is_edit' => true,
            'teamAvailable' => $teamAvailable,
        ]);
    }

    public function update(TeamAvailable $teamAvailable, TeamAvailableRequest $request): RedirectResponse
    {
        $inputs = $request->validated();
        $members = $inputs['members'];
        unset($inputs['members']);

        $teamAvailable->update($inputs);

        TeamAvailableMember::where('team_available_id', $teamAvailable->id)->delete();

        foreach ($members as $key => $member) {
            $members[$key]['team_available_id'] = $teamAvailable->id;
            $members[$key]['updated_at'] = now();
            if (! isset($members[$key]['is_available'])) {
                $members[$key]['is_available'] = false;
            }
        }

        TeamAvailableMember::insert($members);

        return redirect()->route('team_availables')->with('success', 'Date update successfully.');
    }

    public function delete(TeamAvailable $teamAvailable): RedirectResponse
    {
        try {
            $teamAvailable->delete();

            return redirect()->route('team_availables')->with('success', 'Date deleted successfully.');
        } catch (\Exception $e) {
            $message = 'Something went wrong';
            if ($e->getCode() == 23000) {
                $message = 'Data associated with other records cannot be deleted';
            } else {
                Log::error('Team Available Error: '.$e->getMessage());
            }

            return redirect()->back()->with('error', $message);
        }
    }

    public function spotsItemSave(CreateSpotsItemRequest $request)
    {
        $inputs = $request->validated();
        $spots = $inputs['spots'];
        $now = now();

        // 1. Get all existing spot IDs for this team
        $existingSpotIds = TeamSpots::where('team_available_id', $inputs['team_available_id'])->pluck('id')->toArray();

        // 2. Get IDs from request
        $requestSpotIds = array_filter(array_column($spots, 'id'));

        // 3. Find deleted spots
        $deletedIds = array_diff($existingSpotIds, $requestSpotIds);
        if (! empty($deletedIds)) {
            TeamSpots::whereIn('id', $deletedIds)->delete();
        }

        $newSpots = [];
        foreach ($spots as $spot) {
            // Common data for both new and update
            $commonData = [
                'team_available_id' => $inputs['team_available_id'],
                'date' => $inputs['date'],
                'spots_name' => $spot['spots_name'],
                'children' => $spot['children'],
                'women' => $spot['women'],
                'men' => $spot['men'],
                'updated_at' => $now,
            ];

            if (! empty($spot['id'])) {
                // Update existing
                TeamSpots::where('id', $spot['id'])->update($commonData);
            } else {
                // Insert new
                $commonData['created_at'] = $now;
                $newSpots[] = $commonData;
            }
        }

        if (! empty($newSpots)) {
            TeamSpots::insert($newSpots);
        }

        return redirect()->route('team_availables')->with('success', 'Data saved successfully');
    }
}
