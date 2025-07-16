<?php 

namespace App\Models;
use Illuminate\Database\Eloquent\Model;

class Contact extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'gender', 'profile_image', 'additional_file', 'is_merged', 'merged_into_id'
    ];

    public function customFieldValues()
    {
        return $this->hasMany(ContactCustomFieldValue::class);
    }

    public function customFields()
    {
        return $this->belongsToMany(CustomField::class, 'contact_custom_field_values')
            ->withPivot('value');
    }

    public function merges()
    {
        return $this->hasMany(ContactMerge::class, 'master_contact_id');
    }

    public function mergedFrom()
    {
        return $this->hasMany(ContactMerge::class, 'merged_contact_id');
    }
}

