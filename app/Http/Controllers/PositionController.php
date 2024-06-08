<?php

namespace App\Http\Controllers;

use App\Models\Position;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use RealRashid\SweetAlert\Facades\Alert;

class PositionController extends Controller
{
    // Show Data
    public function index(Request $request)
    {
        // Header tabel
        $header = ['No', 'Name', 'Action'];

        // Get Data
        $query['search'] = $request->get('search');
        $positions = Position::where('positionName', 'LIKE', '%' . $query['search'] . '%')->paginate(10)->withQueryString();

        return view('content.position.positionList', compact('header', 'positions', 'query'));
    }

    // Store data
    public function index_add()
    {
        return view('content.position.add');
    }

    public function store(Request $request)
    {
        $request->validate([
            'positionName' => 'required',
        ]);

        // Membuat posisi baru
        $position = Position::create([
            'positionName' => $request->positionName,
        ]);

        // Redirect ke halaman daftar posisi dengan pesan sukses
        return redirect()->route('List Position')->with('success', 'Position created successfully!');
    }

    // update data
    public function index_update($id)
    {
        $positions = Position::find($id);
        return view('content.position.edit', compact('positions'));
    }

    public function update(Request $request, $id)
    {
        // Validasi input
        $request->validate([
            'positionName' => 'required',
        ]);

        // Cari posisi berdasarkan ID
        $position = Position::find($id);

        // Cek apakah posisi ada
        if ($position) {
            // Update posisi
            $position->update([
                'positionName' => $request->positionName,
            ]);

            // Redirect ke halaman daftar posisi dengan pesan sukses
            return redirect()->route('List Position')->with('success', 'Position updated successfully!');
        } else {
            return redirect()->route('List Position')->with('error', 'Position not found!');
        }
    }
}
