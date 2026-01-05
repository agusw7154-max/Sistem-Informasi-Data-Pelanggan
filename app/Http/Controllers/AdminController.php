<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Schema;

class AdminController extends Controller
{
    public function index()
    {
        if (!Schema::hasTable('admin')) {
            return view('errors.no_database');
        }

        $admins = Admin::paginate(15);
        return view('admin.index', compact('admins'));
    }

    public function create()
    {
        return view('admin.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'ID_ADMIN' => 'required|string|max:5',
            'USERNAME' => 'required|string|max:50',
            'PASSWORD' => 'nullable|string|max:60',
            'NAMA_ADMIN' => 'nullable|string|max:100',
        ]);

        Admin::create($data);
        return redirect()->route('admin.index');
    }

    public function show(Admin $admin)
    {
        return view('admin.show', compact('admin'));
    }

    public function edit(Admin $admin)
    {
        return view('admin.edit', compact('admin'));
    }

    public function update(Request $request, Admin $admin)
    {
        $data = $request->validate([
            'USERNAME' => 'required|string|max:50',
            'PASSWORD' => 'nullable|string|max:60',
            'NAMA_ADMIN' => 'nullable|string|max:100',
        ]);

        $admin->update($data);
        return redirect()->route('admin.index');
    }

    public function destroy(Admin $admin)
    {
        $admin->delete();
        return redirect()->route('admin.index');
    }
}
