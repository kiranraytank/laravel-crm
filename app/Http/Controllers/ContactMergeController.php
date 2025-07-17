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
        $contacts = Contact::get();
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
            'contact1_id' => 'required|exists:contacts,id',
            'contact2_id' => 'required|exists:contacts,id|different:contact1_id',
            'fields' => 'required|array',
        ]);

        DB::transaction(function() use ($request) {
            $contact1 = Contact::findOrFail($request->contact1_id);
            $contact2 = Contact::findOrFail($request->contact2_id);

            // Use the selected values for the master
            $master = $contact1;
            $secondary = $contact2;
            // If user picked contact2's name, treat contact2 as master
            if (
                $request->fields['name'] === $contact2->name &&
                $request->fields['email'] === $contact2->email &&
                $request->fields['phone'] === $contact2->phone &&
                $request->fields['gender'] === $contact2->gender
            ) {
                $master = $contact2;
                $secondary = $contact1;
            }

            $oldMasterData = $master->toArray();
            $oldSecondaryData = $secondary->toArray();

            // Update master with selected values
            $master->name = $request->fields['name'];
            $master->email = $request->fields['email'];
            $master->phone = $request->fields['phone'];
            $master->gender = $request->fields['gender'];
            $master->save();

            // Merge custom fields
            $customFields = $request->input('custom_fields', []);
            foreach ($customFields as $cfid => $value) {
                \App\Models\ContactCustomFieldValue::updateOrCreate(
                    [
                        'contact_id' => $master->id,
                        'custom_field_id' => $cfid,
                    ],
                    [
                        'value' => $value,
                    ]
                );
            }

            // Mark secondary as merged
            $secondary->is_merged = true;
            $secondary->merged_into_id = $master->id;
            $secondary->save();

            // Track the merge
            ContactMerge::create([
                'master_contact_id' => $master->id,
                'merged_contact_id' => $secondary->id,
                'merged_data' => json_encode([
                    'old_master' => $oldMasterData,
                    'old_secondary' => $oldSecondaryData,
                    'selected_fields' => $request->fields,
                    'selected_custom_fields' => $customFields,
                ]),
            ]);
        });

        return response()->json(['success' => true, 'message' => 'Contacts merged successfully.']);
    }
}
