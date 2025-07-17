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

    private function abortIfNotAdmin()
    {
        if (!auth()->user() || !auth()->user()->isAdmin()) {
            abort(403, 'Only admin can manage custom fields.');
        }
    }

    public function index()
    {
        $this->abortIfNotAdmin();
        $fields = \App\Models\CustomField::all();
        return view('custom_fields.index', compact('fields'));
    }

    public function store(Request $request)
    {
        $this->abortIfNotAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:custom_fields,name',
            'type' => 'required|string|max:50',
        ]);
        \App\Models\CustomField::create($validated);
        return redirect()->back()->with('success', 'Custom field added.');
    }

    public function destroy(CustomField $customField)
    {
        $this->abortIfNotAdmin();
        $customField->delete();
        return redirect()->back()->with('success', 'Custom field deleted.');
    }

    public function edit(CustomField $customField)
    {
        $this->abortIfNotAdmin();
        return response()->json($customField);
    }

    public function update(Request $request, CustomField $customField)
    {
        $this->abortIfNotAdmin();
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:custom_fields,name,' . $customField->id,
            'type' => 'required|string|max:50',
        ]);
        $customField->update($validated);
        return response()->json(['success' => true, 'message' => 'Custom field updated.']);
    }
}