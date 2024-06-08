<?php

namespace App\Http\Controllers;

use App\Models\Employee;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Imports\EmployeesImport;
use App\Models\Position;
use Illuminate\Support\Facades\Hash;
use Maatwebsite\Excel\Facades\Excel;

class EmployeeController extends Controller
{
    //Show Data
    public function index(Request $request)
    {
        // Mendapatkan ID perusahaan saat ini
        $auth = Auth::guard('employee')->user()->companyId;

        // Header tabel
        $header = ['No', 'Name', 'Date of Birth', 'Gender', 'Email', 'Phone Number', 'Address', 'Position', 'Action'];

        // Mendapatkan query pencarian dari request
        $query['search'] = $request->get('search');

        // Mendapatkan query pencarian dari request
        $query['search'] = $request->get('search'); // Menggunakan variabel $query

        // Query data berdasarkan company dan pencarian
        $employees = Employee::where('companyId', $auth)
            ->where(function ($queryBuilder) use ($query) { // Menggunakan variabel $query
                if ($query['search']) { // Menggunakan variabel $query
                    $queryBuilder->where('employeeName', 'like', '%' . $query['search'] . '%'); // Menggunakan variabel $query
                }
            })->with('companies', 'positions')->paginate(10)->withQueryString();

        // Alert custom sweatalert
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        // Return ke halaman employee
        return view('content.employee.employeeList', compact('header', 'employees', 'query'));
    }

    // Index Add
    public function index_add()
    {
        // Ambil posisi dari tabel position
        $positions = Position::all();

        // Return view ke halaman employee
        return view('content.employee.add', compact('positions'));
    }

    // Store
    public function store(Request $request)
    {
        // Validasi sebelum add
        $request->validate([
            'employeeName' => 'required',
            'DOB' => 'required|date|after:01/01/1900|before:today',
            'employeeEmail' => 'required|unique:employees,employeeEmail',
            'noTelp' => 'required|numeric|digits_between:1,15',
            'positionId' => 'required',
            'employeeAddress' => 'required',
            'gender' => 'required'
        ]);

        $existingEmail = Employee::where('employeeEmail', '!=', $request->employeeEmail)->where(function ($query) use ($request) {
            $query->Where('employeeEmail', $request->employeeEmail);
        })->first();

        if ($existingEmail) {
            if ($existingEmail->employeeEmail === $request->employeeEmail) {
                return redirect()->route('Add Employee')->with('error', 'Email already exists for another employee!');
            }
        }

        // Create data jika validasi success
        Employee::create([
            'employeeName' => $request->employeeName,
            'employeeEmail' => $request->employeeEmail,
            'DOB' => $request->DOB,
            'noTelp' => $request->noTelp,
            'gender' => $request->gender,
            'employeeAddress' => $request->employeeAddress,
            'password' => bcrypt("password"),
            'companyId' => Auth::guard('employee')->user()->companyId,
            'positionId' => $request->positionId,
        ]);

        // Return ke list employee jika success
        return redirect()->route('List Employee')->with('success', 'Employee created successfully!');
    }

    // Index Edit
    public function index_update($id)
    {
        // Cari id berdasarkan session user
        $data = Employee::find($id);

        // Ambil posisi dari tabel position
        $positions = Position::all();

        return view('content.employee.edit', compact('data', 'positions'));
    }

    // update
    public function update(Request $request, $id)
    {
        // Cari employee berdasarkan ID
        $employee = Employee::find($id);

        // Validasi request sebelum mengupdate
        $request->validate([
            'employeeName' => 'required',
            'DOB' => 'required|date|after:01/01/1900|before:today',
            'employeeEmail' => 'required|email',
            'noTelp' => 'required|numeric|digits_between:1,15',
            'positionId' => 'required',
            'employeeAddress' => 'required',
            'gender' => 'required'
        ]);

        // Periksa apakah alamat email yang baru tidak sama dengan alamat email dari employee lain
        $existingEmail = Employee::where('employeeId', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->Where('employeeEmail', $request->employeeEmail);
            })->first();

        if ($existingEmail) {
            if ($existingEmail->employeeEmail === $request->employeeEmail) {
                return redirect()->route('Edit Employee', ['id' => $id])->with('error', 'Email already exists for another employee!');
            }
        }

        // Mengisi atribut yang ingin diubah menggunakan metode fill()
        $employee->fill([
            'employeeName' => $request->employeeName,
            'employeeEmail' => $request->employeeEmail,
            'noTelp' => $request->noTelp,
            'DOB' => $request->DOB,
            'positionId' => $request->positionId,
            'employeeAddress' => $request->employeeAddress,
            'gender' => $request->gender,
        ]);

        $employee->save();

        // Redirect ke halaman edit employee dengan pesan sukses
        return redirect()->route('List Employee')->with('success', 'Employee data updated successfully!');
    }

    // Delete employee
    public function destroy($id)
    {
        $employee = Employee::findOrFail($id); // Dapatkan objek Employee berdasarkan $id
        $employeeName = $employee->employeeName; // Dapatkan employeeName dari objek Employee

        $employee->delete(); // Hapus employee dari basis data
        return redirect()->route('List Employee')->with('success', "$employeeName deleted successfully!");
    }

    // Import employee
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|mimes:xls,xlsx,csv'
        ]);

        // Impor data
        Excel::import(new EmployeesImport, $request->file('file')->store('temp'));

        return redirect()->route('List Employee')->with('success', 'Employees imported successfully.');
    }
    
    // User Profile
    public function index_profile($id)
    {
        // Cek id di tabel sama dengan session dari user
        $data = Employee::where('employeeId', '=', $id)->first();
        return view('content.profile.profile', compact('data'));
    }

    // Update User Profile
    public function update_profile(Request $request, $id)
    {
        // Cari employee berdasarkan ID
        $employee = Employee::find($id);

        // Validasi request sebelum mengupdate
        $request->validate([
            'employeeEmail' => 'required|email',
            'DOB' => 'required|date|after:01/01/1900|before:today',
            'noTelp' => 'required|numeric|digits_between:1,15',
            'employeeAddress' => 'required',
        ]);

        // Periksa apakah alamat email yang baru tidak sama dengan alamat email dari employee lain
        $existingEmail = Employee::where('employeeId', '!=', $id)
            ->where(function ($query) use ($request) {
                $query->Where('employeeEmail', $request->employeeEmail);
            })->first();

        if ($existingEmail) {
            if ($existingEmail->employeeEmail === $request->employeeEmail) {
                return redirect()->route('User Profile', ['id' => $id])->with('error', 'User email already exists for another user!');
            }
        }

        // Mengisi atribut yang ingin diubah menggunakan metode fill()
        $employee->fill([
            'employeeEmail' => $request->employeeEmail,
            'noTelp' => $request->noTelp,
            'DOB' => $request->DOB,
            'employeeAddress' => $request->employeeAddress
        ]);

        // Simpan perubahan
        $employee->save();

        // Redirect ke halaman user profile dengan pesan sukses
        return redirect()->route('User Profile', ['id' => $id])->with('success', 'Your profile updated successfully!');
    }

    // Update User Password
    public function update_password(Request $request, $id)
    {
        // Cari employee berdasarkan ID
        $employee = Employee::find($id);

        // Validasi password sebelum diupdate
        $request->validate([
            'current_password' => 'required',
            'new_password' => 'required|min:8',
            'new_password_confirmation' => 'required|same:new_password',
        ]);

        // Cek current password sama dengan password lama
        if (!Hash::check($request->current_password, $employee->password)) {
            return redirect()->back()->withErrors(['current_password' => 'Current password is incorrect']);
        }

        // Update the password
        $employee->password = Hash::make($request->new_password);

        // Save the changes
        $employee->save();

        // Redirect ke halaman user profile dengan pesan sukses
        return redirect()->route('User Profile', ['id' => $id])->with('success', 'Your password updated successfully!');
    }
}
