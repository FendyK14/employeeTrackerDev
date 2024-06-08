<?php

namespace App\Http\Controllers;

use App\Models\Company;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    public function index($id)
    {
        // Cari id perusahaan berdasarkan session user
        $data = Company::where('companyId', '=', $id)->first();
        return view('content.profile.company', compact('data'));
    }

    // Update Company Profile
    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'companyEmail' => 'required|email',
            'companyPhone' => 'required|numeric|digits_between:1,15',
            'companyAddress' => 'required',
        ]);

        // Cari company berdasarkan ID
        $company = Company::find($id);

        // Cek apakah company ada
        if ($company) {
            // Periksa apakah alamat email yang baru tidak sama dengan alamat email dari perusahaan lain
            $existingCompany = Company::where('companyId', '!=', $id)
                ->where(function ($query) use ($request) {
                    $query->Where('companyEmail', $request->companyEmail);
                })->first();

            if ($existingCompany) {
                if ($existingCompany->companyEmail === $request->companyEmail) {
                    return redirect()->route('Company Profile', ['id' => $id])->with('error', 'Company email already exists for another company.');
                }
            }

            // Mengisi atribut yang ingin diubah menggunakan metode fill()
            $company->fill([
                'companyEmail' => $request->companyEmail,
                'companyPhone' => $request->companyPhone,
                'companyAddress' => $request->companyAddress,
            ]);

            // Simpan perubahan
            $company->save();

            // Redirect ke halaman daftar company dengan pesan sukses
            return redirect()->route('Company Profile', ['id' => $id])->with('success', 'Company profile updated successfully!');
        } else {
            return redirect()->route('Company Profile', ['id' => $id])->with('error', 'Company profile not found!');
        }
    }
}
