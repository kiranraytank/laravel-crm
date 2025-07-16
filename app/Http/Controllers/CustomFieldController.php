<?php

namespace App\Http\Controllers;
use App\Models\CustomField;
use Illuminate\Http\Request;

class CustomFieldController extends Controller
{
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
}