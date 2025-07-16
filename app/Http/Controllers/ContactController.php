<?php 

namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\CustomField;
use App\Models\ContactCustomFieldValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;

class ContactController extends Controller
{
    public function index(Request $request)
    {
        $query = Contact::query()->where('is_merged', false);

        // Filtering
        if ($request->ajax()) {
            if ($request->filled('name')) {
                $query->where('name', 'like', '%' . $request->name . '%');
            }
            if ($request->filled('email')) {
                $query->where('email', 'like', '%' . $request->email . '%');
            }
            if ($request->filled('gender')) {
                $query->where('gender', $request->gender);
            }
            // Optional: filter by custom fields
            if ($request->filled('custom_field')) {
                foreach ($request->custom_field as $fieldId => $value) {
                    $query->whereHas('customFieldValues', function($q) use ($fieldId, $value) {
                        $q->where('custom_field_id', $fieldId)->where('value', 'like', "%$value%");
                    });
                }
            }
        }

        $contacts = $query->with('customFieldValues.customField')->orderBy('id', 'desc')->paginate(10);

        if ($request->ajax()) {
            return view('contacts.partials.list', compact('contacts'))->render();
        }

        $customFields = CustomField::all();
        return view('contacts.index', compact('contacts', 'customFields'));
    }

    public function create()
    {
        $customFields = CustomField::all();
        return view('contacts.create', compact('customFields'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'profile_image' => 'nullable|image|max:2048',
            'additional_file' => 'nullable|file|max:4096',
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_image')) {
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }
        if ($request->hasFile('additional_file')) {
            $validated['additional_file'] = $request->file('additional_file')->store('additional_files', 'public');
        }

        $contact = Contact::create($validated);

        // Save custom fields
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $fieldId => $value) {
                ContactCustomFieldValue::create([
                    'contact_id' => $contact->id,
                    'custom_field_id' => $fieldId,
                    'value' => $value,
                ]);
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Contact created successfully.']);
        }
        return redirect()->route('contacts.index')->with('success', 'Contact created.');
    }

    public function edit(Contact $contact)
    {
        $customFields = CustomField::all();
        $customFieldValues = $contact->customFieldValues->pluck('value', 'custom_field_id');
        return view('contacts.edit', compact('contact', 'customFields', 'customFieldValues'));
    }

    public function update(Request $request, Contact $contact)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email',
            'phone' => 'nullable|string|max:20',
            'gender' => 'nullable|in:male,female,other',
            'profile_image' => 'nullable|image|max:2048',
            'additional_file' => 'nullable|file|max:4096',
        ]);

        // Handle file uploads
        if ($request->hasFile('profile_image')) {
            if ($contact->profile_image) Storage::disk('public')->delete($contact->profile_image);
            $validated['profile_image'] = $request->file('profile_image')->store('profile_images', 'public');
        }
        if ($request->hasFile('additional_file')) {
            if ($contact->additional_file) Storage::disk('public')->delete($contact->additional_file);
            $validated['additional_file'] = $request->file('additional_file')->store('additional_files', 'public');
        }

        $contact->update($validated);

        // Update custom fields
        if ($request->custom_fields) {
            foreach ($request->custom_fields as $fieldId => $value) {
                ContactCustomFieldValue::updateOrCreate(
                    ['contact_id' => $contact->id, 'custom_field_id' => $fieldId],
                    ['value' => $value]
                );
            }
        }

        if ($request->ajax()) {
            return response()->json(['success' => true, 'message' => 'Contact updated successfully.']);
        }
        return redirect()->route('contacts.index')->with('success', 'Contact updated.');
    }

    public function destroy(Contact $contact)
    {
        $contact->delete();
        return response()->json(['success' => true, 'message' => 'Contact deleted.']);
    }

    public function show(Contact $contact)
    {
        $contact->load('customFieldValues.customField');
        return view('contacts.show', compact('contact'));
    }
}