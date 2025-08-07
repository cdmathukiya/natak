<?php

namespace App\Http\Controllers;

use App\Models\Team;
use App\Models\TeamAvailable;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Inertia\Inertia;
use Inertia\Response;

class ReportController extends Controller
{
    public function teamReport(Request $request): Response
    {
        $teams = Team::query();
        $teams = $teams->get()->pluck('name', 'id');

        $fromDate = '';
        $toDate = '';
        $user = Auth::user();

        if ($request->get('from_date') && $request->get('to_date')) {
            $fromDate = Carbon::parse($request->get('from_date'))->format('Y-m-d');
            $toDate = Carbon::parse($request->get('to_date'))->format('Y-m-d');
        }

        $teamAvailables = TeamAvailable::query()
            ->with(['members', 'team.user', 'spots'])
            ->when($request->team_id, function ($q) use ($request) {
                $q->where('team_id', $request->team_id);
            });

        if (! empty($fromDate) && ! empty($toDate)) {
            $teamAvailables->whereBetween('date', [$fromDate, $toDate]);
        }

        if (! $user->isAdmin()) {
            $teamAvailables->whereRelation('team.user', 'id', '=', $user->id);
        }

        $teamAvailables = $teamAvailables->get();

        $date = [
            'from_date' => $fromDate,
            'to_date' => $toDate,
        ];

        return Inertia::render('Report/TeamReport', [
            'teamAvailables' => $teamAvailables,
            'date' => $date,
            'teams' => $teams,
        ]);
    }
}
