<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\invoiceAchiveController;
use App\Http\Controllers\InvoiceAttachmentsController;
use App\Http\Controllers\InvoiceController;
use App\Http\Controllers\InvoiceDetailsController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\SectionController;
use App\Models\invoice;
use App\Models\invoice_attachments;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;







Auth::routes();

// Route::get('/{id}', [AdminController::class, 'index']);
Route::get('/', [HomeController::class, 'login']);
Route::get('/home', [HomeController::class, 'index']);
Route::resource('invoices',InvoiceController::class);
Route::resource('sections',SectionController::class);
Route::resource('products',ProductController::class);
Route::resource('InvoiceAttachments',InvoiceAttachmentsController::class);
Route::resource('Archive',invoiceAchiveController::class);
Route::get('section/{id}',[InvoiceController::class,'getproducts']);
Route::get('/invoicepaid',[InvoiceController::class,'paid']);
Route::get('/invoiceunpaid',[InvoiceController::class,'unpaid']);
Route::get('/View_file/{in}/{fn}',[InvoiceController::class,'open_file']);
Route::get('/download/{in}/{fn}',[InvoiceController::class,'get_file']);
Route::resource('invoicedetails', InvoiceDetailsController::class);
Route::delete('/delete_file', [InvoiceDetailsController::class,'destroy'])->name('delete_file');
Route::post('Status/{id}',[InvoiceController::class,'Status_Update'])->name('Status_Update');


