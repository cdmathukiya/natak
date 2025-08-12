<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamSpots;
use App\Models\User;
use Inertia\Inertia;
use Inertia\Response;

class HomeController extends Controller
{
    public function index(): Response
    {

        $team = Team::where('user_id', auth()->id())
            ->with(['members', 'user', 'teamAvailable.spots'])
            ->first();

        return Inertia::render('Index', [
            'team' => $team,
            'usersCount' => User::count(),
            'teamsCount' => Team::count(),
            'spotsCount' => TeamSpots::count(),
        ]);
    }
}
