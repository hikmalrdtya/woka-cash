<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::whereIn('role', ['finance', 'staff'])->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view('admin.users.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required|unique:users,email',
            'password' => 'required|min:8',
            'role' => 'required|in:finance,staff',
            'photo_profile' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        $photo = null;

        if ($request->hasFile('photo_profile')) {
            $photo = $request->file('photo_profile')->store('photo_profile', 'public');
        }

        User::create([
            'name' => $data['name'],
            'email' => $data['email'],
            'password' => bcrypt($data['password']),
            'role' => $data['role'],
            'photo_profile' => $photo
        ]);

        return redirect()->route('admin.user.index')->with('success', 'User successfuly added');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(User $user)
    {
        return view('admin.users.edit', compact('user'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'string|required|max:255',
            'email' => 'email|required|unique:users,email,' . $user->id,
            'password' => 'nullable|min:8',
            'role' => 'required|in:finance,staff',
            'photo_profile' => 'nullable|image|mimes:jpg,png,jpeg|max:2048'
        ]);

        if (!empty($data['password'])) {
            $data['password'] = bcrypt($data['password']);
        } else {
            unset($data['password']);
        }

        if ($request->hasFile('photo_profile')) {
            if ($user->photo_profile &&  Storage::disk('public')->exists($user->photo_profile)) {
                Storage::disk('public')->delete($user->photo_profile);
            }
            $data['photo_profile'] = $request->file('photo_profile')->store('photo_profile', 'public');
        }

        $user->update($data);

        return redirect()->route('admin.user.index')->with('success', 'User successfuly updated');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(User $user)
    {
        if ($user) {
            $user->delete();
            return redirect()->back()->with('success', 'User successfuly deleted');
        }
    }
}
