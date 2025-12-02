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
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['finance', 'staff']);

        if ($request->filled('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        $users = $query->latest()->paginate(10)->withQueryString();

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

    //edit profile admin
    public function editProfile()
    {
        $admin = auth()->user(); 

        return view('admin.profile.profile', compact('admin'));
    }

    /**
     * Update Profile Admin
     */
    public function updateProfile(Request $request)
    {
        $admin = auth()->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $admin->id,
            'password'  => 'nullable|min:6',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $admin->name  = $request->name;
        $admin->email = $request->email;

        if ($request->filled('password')) {
            $admin->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($admin->photo_profile && Storage::disk('public')->exists($admin->photo_profile)) {
                Storage::disk('public')->delete($admin->photo_profile);
            }

            // Upload foto baru
            $path = $request->file('foto')->store('admin_foto', 'public');
            $admin->photo_profile = $path;
        }

        $admin->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }


    //edit profile finance
    public function editProfileFinance()
    {
        $finance = auth()->user(); 

        return view('finance.profile.profile', compact('finance'));
    }

    /**
     * Update Profile finance
     */
    public function updateProfileFinance(Request $request)
    {
        $finance = auth()->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $finance->id,
            'password'  => 'nullable|min:6',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $finance->name  = $request->name;
        $finance->email = $request->email;

        if ($request->filled('password')) {
            $finance->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($finance->photo_profile && Storage::disk('public')->exists($finance->photo_profile)) {
                Storage::disk('public')->delete($finance->photo_profile);
            }

            // Upload foto baru
            $path = $request->file('foto')->store('finance_foto', 'public');
            $finance->photo_profile = $path;
        }

        $finance->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }


     //edit profile staff
    public function editProfileStaff()
    {
        $staff = auth()->user(); 

        return view('staff.profile.profile', compact('staff'));
    }

    /**
     * Update Profile staff
     */
    public function updateProfileStaff(Request $request)
    {
        $staff = auth()->user();

        $request->validate([
            'name'      => 'required|string|max:255',
            'email'     => 'required|email|unique:users,email,' . $staff->id,
            'password'  => 'nullable|min:6',
            'foto'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $staff->name  = $request->name;
        $staff->email = $request->email;

        if ($request->filled('password')) {
            $staff->password = bcrypt($request->password);
        }

        if ($request->hasFile('foto')) {

            // Hapus foto lama
            if ($staff->photo_profile && Storage::disk('public')->exists($staff->photo_profile)) {
                Storage::disk('public')->delete($staff->photo_profile);
            }

            // Upload foto baru
            $path = $request->file('foto')->store('staff_foto', 'public');
            $staff->photo_profile = $path;
        }

        $staff->save();

        return redirect()->back()->with('success', 'Profil berhasil diperbarui!');
    }
}
