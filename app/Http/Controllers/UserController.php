<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserRequest;
use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Inertia\Inertia;
use Inertia\Response;

class UserController extends Controller
{
    public function index(Request $request): Response
    {
        $query = User::query();
//            ->with('team');
//            ->whereNot('role', '=', 'admin');
        if ($request->has('search')) {
            $search = $request->search;
            $query->where(function ($subQuery) use ($search) {
                $subQuery->whereLike('name', "%$search%")
                    ->orwhereLike('email', "%$search%")
                    ->orWhereLike('is_active', $search == 'active' ? 1 : ($search == 'inactive' ? 0 : null));
            });
        }

        $users = $query->paginate(5)->withQueryString();

        return Inertia::render('User/Index', [
            'users' => $users,
            'filters' => $request->only(['search']),
        ]);
    }

    public function create(): Response
    {
        return Inertia::render('User/Create');
    }

    public function save(UserRequest $request): RedirectResponse
    {
        $inputs = $request->validated();

        if (! empty($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        }

        User::create($inputs);

        return redirect()->route('users')->with('success', 'User Created Successfully');
    }

    public function edit(User $user): Response
    {
        return Inertia::render('User/Create', [
            'userData' => $user,
        ]);
    }

    public function update(User $user, UserRequest $request): RedirectResponse
    {
        $inputs = $request->validated();

        if (! empty($inputs['password'])) {
            $inputs['password'] = Hash::make($inputs['password']);
        } else {
            unset($inputs['password']);
        }

        $user->update($inputs);

        return redirect()->route('users')->with('success', 'User Created Successfully');
    }

    public function delete(User $user): RedirectResponse
    {
        $user->load('team');
        if ($user->team) {
            return redirect()->back()->with('error', 'User is assigned to a team and cannot be deleted.');
        }
        try {
            if ($user->delete()) {
                return redirect()->back()->with('success', 'User Deleted Succefully');
            }
        } catch (\Exception $e) {
            $message = 'Something went wrong';
            if ($e->getCode() == 23000) {
                $message = 'User associated with other records cannot be deleted';
            } else {
                Log::error('User error:'.$e->getMessage());
            }

            return redirect()->back()->with('error', $message);
        }
    }
}
