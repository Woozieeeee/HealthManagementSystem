<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\Role;
use App\Models\Barangay;
use App\Models\Region;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ManageUsersController extends Controller
{
    /**
     * Apply middleware to ensure only authenticated, verified admins can access these methods.
     */
    public function __construct()
    {
        $this->middleware(['auth', 'verified', 'role:admin']);
    }

    /**
     * Display a listing of all active users.
     *
     * @return \Illuminate\View\View
     */
    public function index()
    {
        $users = User::with(['role', 'barangay', 'region'])->paginate(15);
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\View\View
     */
    public function create()
    {
        $roles = Role::all();
        $barangays = Barangay::all();
        $regions = Region::all();

        return view('admin.users.create', compact('roles', 'barangays', 'regions'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users',
            'password' => 'required|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'barangay_id' => 'nullable|exists:barangays,id',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        User::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'password' => Hash::make($validated['password']),
            'role_id' => $validated['role_id'],
            'barangay_id' => $validated['barangay_id'],
            'region_id' => $validated['region_id'],
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    }

    /**
     * Display the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function show(User $user)
    {
        $user->load(['role', 'barangay', 'region']);
        return view('admin.users.show', compact('user'));
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\View\View
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $barangays = Barangay::all();
        $regions = Region::all();

        return view('admin.users.edit', compact('user', 'roles', 'barangays', 'regions'));
    }

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(Request $request, User $user)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $user->id,
            'password' => 'nullable|string|min:8|confirmed',
            'role_id' => 'required|exists:roles,id',
            'barangay_id' => 'nullable|exists:barangays,id',
            'region_id' => 'nullable|exists:regions,id',
        ]);

        $user->update([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'role_id' => $validated['role_id'],
            'barangay_id' => $validated['barangay_id'],
            'region_id' => $validated['region_id'],
            'password' => $validated['password'] ? Hash::make($validated['password']) : $user->password,
        ]);

        return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
    }

    /**
     * Soft delete the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\RedirectResponse
     */
    public function destroy(User $user)
    {
        $user->delete();
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    /**
     * Display a listing of soft-deleted users.
     *
     * @return \Illuminate\View\View
     */
    public function trashed()
    {
        $trashedUsers = User::onlyTrashed()->paginate(15);
        return view('admin.users.trashed', compact('trashedUsers'));
    }

    /**
     * Restore a soft-deleted user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function restore($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->restore();
        return redirect()->route('admin.users.index')->with('success', 'User restored successfully.');
    }

    /**
     * Permanently delete a soft-deleted user.
     *
     * @param  int  $id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function forceDelete($id)
    {
        $user = User::onlyTrashed()->findOrFail($id);
        $user->forceDelete();
        return redirect()->route('admin.users.trashed')->with('success', 'User permanently deleted.');
    }
}
