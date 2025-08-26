<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\PhilosophyPoint;
use App\Models\Status;
use Illuminate\Http\Request;

class PhilosophyPointsController extends Controller
{
    public function index()
    {
        return view('admin.pages.philosophy_points.index');
    }

    public function load(Request $request)
    {
        $query = PhilosophyPoint::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $results = $query->orderBy('sort_order')->paginate(10);

        return view('admin.pages.philosophy_points.index_load', compact('results'));
    }

    public function create()
    {
        $statuses = Status::default();
        return view('admin.pages.philosophy_points.form', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id'
        ]);

        PhilosophyPoint::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Ponto da filosofia criado com sucesso!';
    }

    public function edit($id)
    {
        $result = PhilosophyPoint::findOrFail($id);
        $statuses = Status::default();
        return view('admin.pages.philosophy_points.form', compact('result', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'required|string',
            'icon' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id'
        ]);

        $philosophyPoint = PhilosophyPoint::findOrFail($id);
        $philosophyPoint->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Ponto da filosofia atualizado com sucesso!';
    }

    public function delete($id)
    {
        $philosophyPoint = PhilosophyPoint::findOrFail($id);
        $philosophyPoint->delete();
        return 'Ponto da filosofia excluído com sucesso!';
    }
}


