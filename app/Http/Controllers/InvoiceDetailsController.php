<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\invoice_details;
use App\Models\invoice_attachments;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;


class InvoiceDetailsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $req)
    {
        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        $invoices = invoice::where('id',$id)->first();
        
        $details= invoice_details::where("id_invoice",$id)->get();

        $attachments = invoice_attachments::where('invoice_id',$id)->get();

        

        
        
        return view('invoices.details',compact('invoices','details','attachments'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(invoice_details $invoice_details)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, invoice_details $invoice_details)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
       
        $invoices = invoice_attachments::findOrFail($request->id_file);
        $invoices->delete();
        Storage::disk('public_uploads')->delete($request->invoice_number.'/'.$request->file_name);
        session()->flash('delete', 'تم حذف المرفق بنجاح');
        return back();


    }
}
