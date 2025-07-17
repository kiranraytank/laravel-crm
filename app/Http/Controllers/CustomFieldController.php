<?php

namespace App\Http\Controllers;
use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $fields = CustomField::all();
        return view('custom_fields.index', compact('fields'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:custom_fields,name',
            'type' => 'required|string|max:50',
        ]);
        CustomField::create($validated);
        return redirect()->back()->with('success', 'Custom field added.');
    }

    public function destroy(CustomField $customField)
    {
        $customField->delete();
        return redirect()->back()->with('success', 'Custom field deleted.');
    }

    public function edit(CustomField $customField)
    {
        return response()->json($customField);
    }

    public function update(Request $request, CustomField $customField)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:custom_fields,name,' . $customField->id,
            'type' => 'required|string|max:50',
        ]);
        $customField->update($validated);
        return response()->json(['success' => true, 'message' => 'Custom field updated.']);
    }
}