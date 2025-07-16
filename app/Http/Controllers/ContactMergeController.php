<?php
namespace App\Http\Controllers;
use App\Models\Contact;
use App\Models\ContactMerge;
use App\Models\ContactCustomFieldValue;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ContactMergeController extends Controller
{
    public function showMergeForm(Request $request)
    {
        $contacts = Contact::where('is_merged', false)->get();
        return view('contacts.merge', compact('contacts'));
    }

    public function getMergeModal(Request $request)
    {
        $contact1 = Contact::findOrFail($request->contact1);
        $contact2 = Contact::findOrFail($request->contact2);
        return view('contacts.partials.merge_modal', compact('contact1', 'contact2'))->render();
    }

    public function merge(Request $request)
    {
        $request->validate([
            'master_id' => 'required|exists:contacts,id',
            'secondary_id' => 'required|exists:contacts,id|different:master_id',
        ]);

        DB::transaction(function() use ($request) {
            $master = Contact::findOrFail($request->master_id);
            $secondary = Contact::findOrFail($request->secondary_id);

            $mergedData = [
                'secondary_contact' => $secondary->toArray(),
                'secondary_custom_fields' => $secondary->customFieldValues->toArray(),
            ];

            // Merge emails/phones if different
            if ($master->email !== $secondary->email && $secondary->email) {
                $master->email .= ', ' . $secondary->email;
            }
            if ($master->phone !== $secondary->phone && $secondary->phone) {
                $master->phone .= ', ' . $secondary->phone;
            }

            // Merge custom fields
            $masterFields = $master->customFieldValues->pluck('value', 'custom_field_id');
            foreach ($secondary->customFieldValues as $secField) {
                if (!$masterFields->has($secField->custom_field_id)) {
                    // Master missing this field, add it
                    ContactCustomFieldValue::create([
                        'contact_id' => $master->id,
                        'custom_field_id' => $secField->custom_field_id,
                        'value' => $secField->value,
                    ]);
                } else {
                    // Both have, keep master's value (policy), but preserve secondary in merged_data
                }
            }

            $master->save();

            // Mark secondary as merged
            $secondary->is_merged = true;
            $secondary->merged_into_id = $master->id;
            $secondary->save();

            // Track the merge
            ContactMerge::create([
                'master_contact_id' => $master->id,
                'merged_contact_id' => $secondary->id,
                'merged_data' => json_encode($mergedData),
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Contacts merged successfully.']);
    }
}
