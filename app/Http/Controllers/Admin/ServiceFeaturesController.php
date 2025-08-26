<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceFeature;
use App\Models\Status;
use Illuminate\Http\Request;

class ServiceFeaturesController extends Controller
{
    public function index()
    {
        return view('admin.pages.service_features.index');
    }

    public function load(Request $request)
    {
        $query = ServiceFeature::query();

        if ($request->filled('title')) {
            $query->where('title', 'like', '%' . $request->title . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $results = $query->orderBy('sort_order')->paginate(10);

        return view('admin.pages.service_features.index_load', compact('results'));
    }

    public function create()
    {
        $statuses = Status::all();
        return view('admin.pages.service_features.form', compact('statuses'));
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

        ServiceFeature::create([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Recurso do serviço criado com sucesso!';
    }

    public function edit($id)
    {
        $result = ServiceFeature::findOrFail($id);
        $statuses = Status::all();
        return view('admin.pages.service_features.form', compact('result', 'statuses'));
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

        $serviceFeature = ServiceFeature::findOrFail($id);
        $serviceFeature->update([
            'title' => $request->title,
            'description' => $request->description,
            'icon' => $request->icon,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Recurso do serviço atualizado com sucesso!';
    }

    public function delete($id)
    {
        $serviceFeature = ServiceFeature::findOrFail($id);
        $serviceFeature->delete();
        return 'Recurso do serviço excluído com sucesso!';
    }
}


