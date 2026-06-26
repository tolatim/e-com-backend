<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Validation\Rule;

class UserController extends Controller
{
    /**
     * Display a listing of users with search.
     */
    public function index(Request $request)
    {
        $query = User::query();

        // Search by name or email
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Filter by role
        if ($request->filled('role') && in_array($request->role, ['admin', 'customer'])) {
            $query->where('role', $request->role);
        }

        // Filter by status
        if ($request->filled('status')) {
            if ($request->status === 'blocked') {
                $query->whereNotNull('blocked_at');
            } elseif ($request->status === 'active') {
                $query->whereNull('blocked_at');
            }
        }

        $users = $query->latest()->paginate(15)->withQueryString();

        return view('admin.users.index', compact('users'));
    }

    /**
     * Display the specified user with their order history.
     */
    public function show(User $user)
    {
        // Load orders with items and products
        $orders = $user->orders()
            ->with('items.product')
            ->latest()
            ->paginate(10);

        return view('admin.users.show', compact('user', 'orders'));
    }

    /**
     * Show the form for editing the specified user.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified user in storage.
     */
    public function update(Request $request, User $user)
    {
        if ($user->id === auth()->id() && $request->role !== 'admin') {
            return back()->with('error', 'You cannot remove your own admin access.');
        }
        

        $validated = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255', Rule::unique('users')->ignore($user->id)],
            'role'  => ['required', Rule::in(['admin', 'customer'])],
        ]);

        $user->update($validated);
        
        return redirect()
            ->route('admin.users.show', $user)
            ->with('success', 'User information updated successfully.');
    }

    /**
     * Toggle block / unblock a user.
     */
    public function toggleBlock(User $user)
    {
        // Prevent admin from blocking themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot block your own account.');
        }

        if ($user->blocked_at) {
            $user->update(['blocked_at' => null]);
            $message = "User \"{$user->name}\" has been unblocked.";
        } else {
            $user->update(['blocked_at' => now()]);
            $message = "User \"{$user->name}\" has been blocked.";
        }

        return back()->with('success', $message);
    }

    /**
     * Remove the specified user from storage.
     */
    public function destroy(User $user)
    {
        // Prevent admin from deleting themselves
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot delete your own account.');
        }

        $name = $user->name;
        $user->delete();

        return redirect()
            ->route('admin.users.index')
            ->with('success', "User \"{$name}\" has been deleted.");
    }
}
