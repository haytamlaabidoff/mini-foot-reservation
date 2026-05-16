<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Staff;
use App\Models\User;
   use Illuminate\Support\Facades\Hash;
   use App\Models\Post;
use App\Models\Department;

class StaffController extends Controller
{
    // 📋 عرض جميع الموظفين
    public function index()
    {
        $staff = Staff::with('user')->latest()->get();
        return view('staff.index', compact('staff'));
    }

    // ➕ صفحة إنشاء موظف
    public function create()
    {
        $users = User::where('role', '!=', 'staff')->get(); // تجنب التكرار
         $departments = Department::all();
    $posts = Post::all();
        return view('staff.create', compact('users', 'departments', 'posts'));
    }

    public function card($id)
{
    $staff = Staff::with(['user', 'department', 'post'])->where('user_id', $id)->firstOrFail();

    return view('staff.card', compact('staff'));
}
    // 💾 حفظ موظف جديد



public function store(Request $request)
{
    $request->validate([
        'name' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',

        'post_id' => 'required|exists:posts,id',
        'department_id' => 'required|exists:departments,id',

        'phone' => 'nullable|string',
        'cin' => 'required|string|unique:staff,cin',

        'address' => 'nullable|string',
        'salary' => 'nullable|numeric',
        'status' => 'required|in:active,inactive',

        // 🆕 IMAGE VALIDATION
        'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
    ]);

    // employee code
    $lastStaff = Staff::orderBy('id', 'desc')->first();
    $nextNumber = $lastStaff ? $lastStaff->id + 1 : 1;
    $employeeCode = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);

    // 🔥 CIN = PASSWORD
    $plainPassword = $request->cin;

    // USER (login)
    $user = User::create([
        'name' => $request->name,
        'email' => $request->email,
        'password' => Hash::make($plainPassword),
        'role' => 'staff',
    ]);

    // 🆕 upload image
    $imagePath = null;

    if ($request->hasFile('image')) {
        $imagePath = $request->file('image')->store('staff', 'public');
    }

    // STAFF (profil)
    Staff::create([
        'user_id' => $user->id,
        'employee_code' => $employeeCode,

        'post_id' => $request->post_id,
        'department_id' => $request->department_id,

        'phone' => $request->phone,
        'cin' => $request->cin,
        'address' => $request->address,

        'salary' => $request->salary,
        'hire_date' => $request->hire_date,
        'status' => $request->status,

        // 🆕 IMAGE SAVE
        'image' => $imagePath,
    ]);

    return redirect()->route('staff.index')
        ->with('success', 'Staff créé avec image + CIN = password');
}
// ✏️ تعديل
    public function edit($id)
    {
        $staff = Staff::findOrFail($id);
        $users = User::all();

        return view('staff.edit', compact('staff', 'users'));
    }

    // 🔄 تحديث
 public function update(Request $request, $id)
{
    $staff = Staff::findOrFail($id);

    $request->validate([
        'post_id' => 'required|exists:posts,id',
        'department_id' => 'required|exists:departments,id',

        'phone' => 'nullable|string',
        'cin' => 'nullable|string',
        'address' => 'nullable|string',

        'salary' => 'nullable|numeric',
        'status' => 'required|in:active,inactive',
    ]);

    $staff->update([
        'post_id' => $request->post_id,
        'department_id' => $request->department_id,

        'phone' => $request->phone,
        'cin' => $request->cin,
        'address' => $request->address,

        'salary' => $request->salary,
        'status' => $request->status,
    ]);

    return redirect()->route('staff.index')
        ->with('success', 'Staff mis à jour');
}

    // ❌ حذف
    public function destroy($id)
    {
        $staff = Staff::findOrFail($id);

        // ترجع role ديال user إلى client
        $staff->user->update(['role' => 'client']);

        $staff->delete();

        return redirect()->back()->with('success', 'Staff supprimé');
    }
}