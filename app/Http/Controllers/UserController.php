<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Branch;
use App\Models\Region;
use App\Models\Department;
use App\Models\District;
use App\Models\Rank;
use App\Models\Command;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;


use Illuminate\Support\Facades\Auth;


class UserController extends Controller
{
    /**
     * Display a listing of the users.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::all(); // Fetch all users
        return view('users.index', compact('users'));
    }

    /**
     * Show the form for creating a new user.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $roles = Role::all(); // Get all roles
        $branches = Branch::all();
        //$regions = Region::all();
        $departments = Department::all();
        $districts = District::all();
        $commands = Command::all();
        $ranks = Rank::all(); // Fetch all ranks

        $regions = Region::with('districts')->get(); // Fetch regions with their districts
        return view('users.create', compact('roles','branches', 'regions', 'departments', 'districts', 'commands','ranks'));
    }

    /**
     * Store a newly created user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validatedData = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users',
            'password' => 'required|string|min:6',
            'branch_id' => 'nullable|exists:branches,id',
            'designation' => 'nullable|string|max:255',
            'rank' => 'nullable|string|max:255',
            'status' => 'required|string',
            'phone_number' => 'nullable|string|max:255',

            //'branch_id_employee' => 'required|exists:branches,id',
            'region_id' => 'required|exists:regions,id',
            'department_id' => 'required|exists:departments,id',
            'district_id' => 'required|exists:districts,id',
            'command_id' => 'required|exists:commands,id',
        ]);

        $validatedData['password'] = Hash::make($validatedData['password']); // Hash password before saving

    $user = User::create($validatedData); // Create the user with validated data
    $user->assignRole($request->role); // Assign the selected role to the new user

    return redirect()->route('users.index')->with('success', 'User created successfully.');
    }

    /**
     * Show the form for editing the specified user.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function edit(User $user)
    {
        $roles = Role::all();
        $branches = Branch::all();
        $departments = Department::all();
        $districts = District::all();
        $commands = Command::all();
        $ranks = Rank::all();
        $regions = Region::with('districts')->get();

        return view('users.edit', compact('user', 'roles', 'branches', 'regions', 'departments', 'districts', 'commands','ranks'));
    }

    //show user
    public function show($id)
    {
        $user = User::with(['branch', 'role', 'region', 'department', 'district', 'command', 'rank'])->findOrFail($id);
        return view('users.view', compact('user'));
    }
    
    

    /**
     * Update the specified user in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    // public function update(Request $request, User $user)
    // {
    //     $validatedData = $request->validate([
    //         'name' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255|unique:users,email,' . $user->id,
    //         'password' => 'sometimes|string|min:6',
    //         'branch_id' => 'nullable|exists:branches,id',
    //         'designation' => 'nullable|string|max:255',
    //         'rank' => 'nullable|string|max:255',
    //         'status' => 'required|string',
    //         'phone_number' => 'nullable|string|max:255',
    //         'role' => 'required|string|exists:roles,name'
    //     ]);

    //     if (!empty($validatedData['password'])) { // Check if password was entered and needs to be updated
    //         $validatedData['password'] = Hash::make($validatedData['password']);
    //     } else {
    //         unset($validatedData['password']); // Remove password from array if not being updated
    //     }

    //     $user->update($validatedData); // Update user data

    //     return redirect()->route('users.index')->with('success', 'User updated successfully.');
    // }


    public function update(Request $request, User $user)
{
    // Validate the data, but make sure fields are optional unless they are being updated
    $validatedData = $request->validate([
        'name' => 'nullable|string|max:255', // Make name optional
        'email' => 'nullable|string|email|max:255|unique:users,email,' . $user->id, // Make email optional, with exception for the current user
        'branch_id' => 'nullable|exists:branches,id',
        'designation' => 'nullable|string|max:255',
        'status' => 'nullable|string', // Make status optional
        'phone_number' => 'nullable|string|max:255',
        'region_id' => 'nullable|exists:regions,id',
        'department_id' => 'nullable|exists:departments,id',
        'district_id' => 'nullable|exists:districts,id',
        'command_id' => 'nullable|exists:commands,id',
        'password' => 'nullable|string|min:6', // Allow password to be optional
    ]);

    // If a password is provided, hash it
    if ($request->filled('password')) {
        $validatedData['password'] = Hash::make($validatedData['password']);
    } else {
        unset($validatedData['password']); // If no password is provided, don't include it in the update
    }

    try {
        // Update the user with the validated data
        $user->update($validatedData);

        // If roles are included in the request, sync them
        if ($request->has('role')) {
            $user->syncRoles($request->role); // Sync roles if provided
        }

        return redirect()->route('users.index')->with('success', 'User updated successfully.');
    } catch (\Exception $e) {
        Log::error('User update failed', ['error' => $e->getMessage()]);
        return back()->with('error', 'Failed to update user.');
    }
}


    /**
     * Remove the specified user from storage.
     *
     * @param  \App\Models\User  $user
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user)
    {
        $user->delete(); // Delete the user

        return redirect()->route('users.index')->with('success', 'User deleted successfully.');
    }
















 /**
     * Show the user profile.
     */
    public function profile()
    {
        $user = Auth::user()->load('rank', 'role'); // Load rank and role relationships
        return view('users.profile', compact('user'));
    }
    

    /**
     * Handle the password update request.
     */
    public function updatePassword(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|confirmed|min:8',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'The provided password does not match our records.']);
        }

        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->route('profile')->with('success', 'Password updated successfully.');
    }





}
