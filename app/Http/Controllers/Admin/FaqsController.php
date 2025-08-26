<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Faq;
use App\Models\Status;
use Illuminate\Http\Request;

class FaqsController extends Controller
{
    public function index()
    {
        return view('admin.pages.faqs.index');
    }

    public function load(Request $request)
    {
        $query = Faq::query();

        if ($request->filled('question')) {
            $query->where('question', 'like', '%' . $request->question . '%');
        }

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        $results = $query->orderBy('sort_order')->paginate(10);

        return view('admin.pages.faqs.index_load', compact('results'));
    }

    public function create()
    {
        $statuses = Status::all();
        return view('admin.pages.faqs.form', compact('statuses'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id'
        ]);

        Faq::create([
            'question' => $request->question,
            'answer' => $request->answer,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Pergunta frequente criada com sucesso!';
    }

    public function edit($id)
    {
        $result = Faq::findOrFail($id);
        $statuses = Status::all();
        return view('admin.pages.faqs.form', compact('result', 'statuses'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'question' => 'required|string|max:255',
            'answer' => 'required|string',
            'sort_order' => 'nullable|integer',
            'status' => 'required|exists:statuses,id'
        ]);

        $faq = Faq::findOrFail($id);
        $faq->update([
            'question' => $request->question,
            'answer' => $request->answer,
            'sort_order' => $request->sort_order ?? 0,
            'status' => $request->status
        ]);

        return 'Pergunta frequente atualizada com sucesso!';
    }

    public function delete($id)
    {
        $faq = Faq::findOrFail($id);
        $faq->delete();
        return 'Pergunta frequente excluída com sucesso!';
    }
}


