<?php 

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\ContactMergeController;


Auth::routes();

Route::get('/', [ContactController::class, 'index'])->name('contacts.index');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

// 🟢 Custom routes FIRST
Route::post('contacts/store', [ContactController::class, 'store'])->name('contacts.store');

Route::get('contacts/merge', [ContactMergeController::class, 'showMergeForm'])->name('contacts.merge.form');
Route::post('contacts/merge-modal', [ContactMergeController::class, 'getMergeModal'])->name('contacts.merge.modal');
Route::post('contacts/merge', [ContactMergeController::class, 'merge'])->name('contacts.merge');
Route::get('contacts/merge-details/{contact}', [App\Http\Controllers\ContactMergeController::class, 'mergeDetails'])->name('contacts.merge.details');

Route::get('custom-fields', [CustomFieldController::class, 'index'])->name('custom_fields.index');
Route::post('custom-fields', [CustomFieldController::class, 'store'])->name('custom_fields.store');
Route::delete('custom-fields/{customField}', [CustomFieldController::class, 'destroy'])->name('custom_fields.destroy');
Route::get('custom-fields/{customField}/edit', [App\Http\Controllers\CustomFieldController::class, 'edit'])->name('custom_fields.edit');
Route::post('custom-fields/{customField}/update', [App\Http\Controllers\CustomFieldController::class, 'update'])->name('custom_fields.update');

// 🟡 These should be below
Route::post('contacts/{contact}/update', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

Route::get('contacts/merged-list', [ContactController::class, 'mergedList'])->name('contacts.merged.list');

Route::get('/contacts', [ContactController::class, 'index'])->name('contacts.index');

// 🔴 LAST: Dynamic resource route (this is what was conflicting)
Route::resource('contacts', ContactController::class)->except(['index']);

