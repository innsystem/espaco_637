<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Statistic;
use App\Models\Status;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function index()
    {
        return view('admin.pages.statistics.index');
    }

    public function load(Request $request)
    {
        $query = Statistic::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $results = $query->orderBy('sort_order')->paginate(10);

        return view('admin.pages.statistics.index_load', compact('results'));
    }

    public function create()
    {
        $statuses = Status::default();
        return view('admin.pages.statistics.form', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id'
        ]);

        Statistic::create([
            'title' => $request->title,
            'value' => $request->value,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Estatística criada com sucesso!';
    }

    public function edit($id)
    {
        $result = Statistic::findOrFail($id);
        $statuses = Status::default();
        return view('admin.pages.statistics.form', compact('result', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'value' => 'required|string|max:255',
            'sort_order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id'
        ]);

        $statistic = Statistic::findOrFail($id);
        $statistic->update([
            'title' => $request->title,
            'value' => $request->value,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Estatística atualizada com sucesso!';
    }

    public function delete($id)
    {
        $statistic = Statistic::findOrFail($id);
        $statistic->delete();
        return 'Estatística excluída com sucesso!';
    }
}


