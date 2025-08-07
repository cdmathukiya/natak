<?php

namespace App\Http\Controllers;

use App\Http\Requests\TeamRequest;
use App\Models\Member;
use App\Models\Team;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class TeamController extends Controller
{
    public function index(Request $request): Response
    {
        $query = Team::query()
            ->with('user:id,name');

        if ($request->has('search')) {
            $search = $request->search;
            $query->whereLike('name', "%$search%")
                ->orwhereLike('kendra', "%$search%")
                ->orWhereRelation('user', function ($q) use ($search) {
                    $q->whereLike('name', "%$search%");
                });
        }

        $teams = $query->paginate(5)->withQueryString();

        return Inertia::render('Team/Index', [
            'teams' => $teams,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        $users = User::query()
            ->where('role', 'user')
            ->pluck('name', 'id');

        return Inertia::render('Team/Create', [
            'users' => $users,
        ]);
    }

    public function save(TeamRequest $request): RedirectResponse
    {
        $inputs = $request->validated();
        $members = $inputs['members'];
        unset($inputs['members']);

        $team = Team::create($inputs);

        foreach ($members as $key => $member) {
            $members[$key]['team_id'] = $team->id;
            $members[$key]['created_at'] = now();
            $members[$key]['updated_at'] = now();
        }

        Member::insert($members);

        return redirect()->route('teams')->with('success', 'Team created successfully');
    }

    public function show(Team $team): Response
    {
        $team->load(['members', 'user', 'teamAvailable.spots']);

        return Inertia::render('Team/Show', [
            'team' => $team,
        ]);
    }

    public function edit(Team $team): Response
    {
        $users = User::query()
            ->where('role', 'user')
            ->pluck('name', 'id');
        $team->load(['members', 'user:id,name']);

        return Inertia::render('Team/Create', [
            'team' => $team,
            'users' => $users,
        ]);
    }

    public function update(Team $team, TeamRequest $request): RedirectResponse
    {
        $inputs = $request->validated();
        $members = $inputs['members'];
        unset($inputs['members']);

        $team->update($inputs);

        Member::where('team_id', $team->id)->delete();

        foreach ($members as $key => $member) {
            $members[$key]['team_id'] = $team->id;
            $members[$key]['created_at'] = now();
            $members[$key]['updated_at'] = now();
        }

        Member::insert($members);

        return redirect()->route('teams')->with('success', 'Team updated successfully.');
    }

    public function delete(Team $team): RedirectResponse
    {
        try {
            $team->delete();

            return redirect()->route('teams')->with('success', 'Team deleted successfully.');
        } catch (\Exception $e) {
            $message = 'Something went wrong';
            if ($e->getCode() == 23000) {
                $message = 'Team associated with other records cannot be deleted';
            } else {
                Log::error('Team Error: '.$e->getMessage());
            }

            return redirect()->back()->with('error', $message);
        }
    }
}
