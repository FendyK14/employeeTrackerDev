<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class GroupController extends Controller
{
    // Index group
    public function index(Request $request)
    {
        // Mendapatkan ID pegawai yang sedang login
        $employeeId = Auth::guard('employee')->user()->employeeId;

        // Search
        $query['search'] = $request->get('search');
        // Query group berdasarkan $query
        $groups = Group::where('groupName', 'LIKE', '%' . $query['search'] . '%')
            ->whereHas('employees', function ($query) use ($employeeId) {
                $query->where('employees.employeeId', $employeeId); // Memastikan pengguna adalah pemilik grup
            })->with('employees')->paginate(9)->withQueryString();

        // Return view ketika success
        return view('content.group.group', compact('groups', 'query'));
    }

    // Index add
    public function index_add()
    {
        return view('content.group.add');
    }

    // Store
    public function store(Request $request)
    {
        $request->validate([
            'groupName' => 'required'
        ]);

        $group = Group::create([
            'groupName' => $request->groupName
        ]);

        $auth = Auth::guard('employee')->user()->employeeId;

        $group->employees()->attach($auth, ['isLeader' => true]);

        return redirect()->route('Group List')->with('success', 'Group created successfully!');
    }

    // Index Detail
    public function index_detail($id)
    {
        // Header tabel
        $header = ['No', 'Name', 'Email', 'Position', 'Action'];

        // Mengambil detail group beserta employees-nya
        $groups = Group::with('employees')->find($id);

        if (!$groups) {
            // Handle jika group tidak ditemukan, misalnya dengan redirect atau menampilkan pesan error
            return redirect()->back()->with('error', 'Group not found.');
        }

        // Mengambil employees dari group
        $details = $groups->employees;

        // Alert custom sweatalert
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        // dd($details);
        return view('content.group.member', compact('header', 'details', 'groups'));
    }

    // Index Member
    public function index_member($id)
    {
        // Cari user yang login
        $auth = Auth::guard('employee')->user()->employeeId;

        // Mengambil detail group beserta employees-nya
        $groups = Group::with('employees')->find($id);
        // Query employee dimana tidak sama dengan auth
        $employees = Employee::where('employeeId', '!=', $auth)->whereNotIn('positionId', [1, 2])->get();

        return view('content.group.add-member', compact('groups', 'employees'));
    }

    public function store_member(Request $request, $id)
    {
        $request->validate([
            'employeeId' => 'required',
        ]);

        // Temukan grup berdasarkan ID
        $group = Group::find($id);

        // cek apakah id sama dengan grup
        if (!$group) {
            return redirect()->back()->with('error', 'Group not found.');
        }

        // Cek apakah karyawan sudah ada di grup
        if ($group->employees()->where('detail_employee_groups.employeeId', $request->employeeId)->exists()) {
            return redirect()->route('Add Member', ['id' => $id])->with('error', 'Member already exists in this group.');
        }

        // Tambahkan karyawan ke grup
        $group->employees()->attach($request->employeeId, ['isLeader' => false]);

        // Return ke route ketika berhasil add member
        return redirect()->route('Group Detail', ['id' => $id])->with('success', 'Member added successfully!');
    }

    // Index Update
    public function index_update($id)
    {
        // Mengambil detail group beserta employees-nya
        $groups = Group::find($id);

        return view('content.group.edit', compact('groups'));
    }

    public function update(Request $request, $id)
    {
        // Validasi sebelum menambahkan group
        $request->validate([
            'groupName' => 'required',
        ]);

        // Cari id grup berdasarkan request
        $group = Group::find($id);

        // jika id ditemukan lakukan update nama grup
        $group->update([
            'groupName' => $request->groupName,
        ]);

        return redirect()->route('Group Detail', ['id' => $id])->with('success', 'Group updated successfully!');
    }

    // Delete
    public function destroy($id)
    {
        $group = Group::findOrFail($id); // Dapatkan objek group berdasarkan $id
        $groupName = $group->groupName; // Dapatkan groupName dari objek group

        $group->delete(); // Hapus group dari basis data
        return redirect()->route('Group List')->with('success', "$groupName deleted successfully!");
    }

    // Delete member
    public function destroy_member($groupId, $employeeId)
    {
        // Temukan karyawan berdasarkan ID
        $employee = Employee::findOrFail($employeeId);

        // Temukan grup berdasarkan ID
        $group = Group::findOrFail($groupId);

        // Hapus karyawan dari grup tertentu
        $group->employees()->detach($employeeId);

        // Redirect pengguna kembali ke halaman yang sesuai
        return redirect()->route('Group Detail', ['id' => $groupId])->with('success', "Member successfully removed from group!");
    }
}
