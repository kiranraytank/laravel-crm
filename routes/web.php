<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Auth::routes();

Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

use App\Http\Controllers\ContactController;
use App\Http\Controllers\CustomFieldController;
use App\Http\Controllers\ContactMergeController;

Route::get('/', [ContactController::class, 'index'])->name('contacts.index');
Route::resource('contacts', ContactController::class)->except(['index']);
Route::post('contacts/store', [ContactController::class, 'store'])->name('contacts.store');
Route::post('contacts/{contact}/update', [ContactController::class, 'update'])->name('contacts.update');
Route::delete('contacts/{contact}', [ContactController::class, 'destroy'])->name('contacts.destroy');

Route::get('custom-fields', [CustomFieldController::class, 'index'])->name('custom_fields.index');
Route::post('custom-fields', [CustomFieldController::class, 'store'])->name('custom_fields.store');
Route::delete('custom-fields/{customField}', [CustomFieldController::class, 'destroy'])->name('custom_fields.destroy');

Route::get('contacts/merge', [ContactMergeController::class, 'showMergeForm'])->name('contacts.merge.form');
Route::post('contacts/merge-modal', [ContactMergeController::class, 'getMergeModal'])->name('contacts.merge.modal');
Route::post('contacts/merge', [ContactMergeController::class, 'merge'])->name('contacts.merge');
