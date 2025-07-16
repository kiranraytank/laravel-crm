<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ContactSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $contact = \App\Models\Contact::create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'phone' => '9999999999',
            'gender' => 'Male',
            'is_merged' => false,
        ]);

        // Add a custom field value (optional)
        $cf = \App\Models\CustomField::first();
        if ($cf) {
            \App\Models\ContactCustomFieldValue::create([
                'contact_id' => $contact->id,
                'custom_field_id' => $cf->id,
                'value' => 'Sample Value'
            ]);
        }
    }

}
