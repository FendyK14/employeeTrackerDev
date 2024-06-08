<?php

namespace App\Http\Controllers;

use App\Models\Sub_Activity;
use Illuminate\Http\Request;

class SubActivityController extends Controller
{
    // Index
    public function index(Request $request){

        // Header tabel
        $header = ['No', 'Sub Activity Name', 'Action'];

        // Mendapatkan query pencarian dari request
        $query['search'] = $request->get('search');

        // Query Sub Activity berdasarkan $query
        $subActivity = Sub_Activity::where('subActivityName', 'LIKE', '%' . $query['search'] . '%')
            ->paginate(10)->withQueryString();

        return view('content.subActivity.subActivityList', compact('header', 'subActivity', 'query'));
    }

    // Store
    public function index_add (){
        return view('content.subActivity.subActivity-add');
    }

    public function store(Request $request){
        $request->validate([
            'subActivityName' => 'required',
        ]);

        //check existing sub activity
        $existing = Sub_Activity::where('subActivityName', '=', $request->subActivityName)->first();

        if($existing){
            return redirect()->route('Add Subactivity')->with('error', 'Sub Activity already exists!');
        }

        Sub_Activity::create([
            'subActivityName' => $request->subActivityName,
        ]);

        //redirect back to list sub activity
        return redirect()->route('List Subactivity')->with('success', 'Sub Activity created successfully!');
    }

    // Update
    public function index_update($id){
        // Cari id sub Activity
        $subActivity = Sub_Activity::find($id);

        // Return view jika id berhasil ditemukan
        return view('content.subActivity.subActivity-edit', compact('subActivity'));
    }

    public function update(Request $request, $id){
        // Validasi sebelum melakukan update
        $request->validate([
            'subActivityName' => 'required',
        ]);

        // Cari project berdasarkan id
        $subActivity = Sub_Activity::find($id);

        //check existing sub activity
        $existing = Sub_Activity::where('subActivityName', '=', $request->subActivityName)->first();

        if($existing && $existing->id != $id){
            return redirect()->route('Edit Subactivity', ['id' => $id])->with('error', 'Sub Activity already exists!');
        }

        // jika id ditemukan lakukan update pada project
        $subActivity->fill([
            'subActivityName' => $request->subActivityName,
        ]);

        // Simpan perubahan
        $subActivity->save();

        return redirect()->route('List Subactivity')->with('success', 'Sub Activity updated successfully!');
    }
}
