<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\Comment;
use App\Models\Group;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CommentController extends Controller
{
    //Index Komentar
    public function index($id)
    {
        // Ambil Nama Project berdasarkan Id
        $comments = Comment::whereHas('activities', function ($query) use ($id) {
            $query->where('activities.activityId', $id);
        })->get();

        $activity = Activity::find($id);
        // Alert custom sweatalert
        $title = 'Delete Data!';
        $text = "Are you sure you want to delete?";
        confirmDelete($title, $text);

        return view('content.comment.comment', compact('comments', 'activity'));
    }

    // Store
    public function store(Request $request, $id)
    {
        // cek request
        $request->validate([
            'description' => 'nullable',
        ]);

        // Dapatkan employeeId yang terautentikasi
        $employeeId = Auth::guard('employee')->user()->employeeId;

        // Buat komentar baru
        $comment = Comment::create([
            'description' => $request->description,
            'employeeId' => $employeeId, // Gunakan employeeId untuk menyimpan ID pengguna
        ]);

        // Attach komentar ke aktivitas
        $comment->activities()->attach($id);

        // Redirect kembali ke halaman sebelumnya
        return redirect()->back();
    }

    // Delete
    public function destroy($id)
    {
        // Cek id komentar
        $comment = Comment::findOrFail($id);
        // delete jika id ditemukan
        $comment->delete();

        // return ke route komentar
        return redirect()->back()->with('success', 'Comment deleted successfully');
    }

    // Update
    public function update(Request $request, $id)
    {
        // validasi sebelum update
        $request->validate([
            'description' => 'nullable'
        ]);

        // Cek id komentar yang ingin di update
        $comment = Comment::find($id);

        $comment->fill([
            'description' => $request->description,
        ]);

        $comment->save();

        return redirect()->back()->with('success', 'Comment updated successfully');
    }
}
