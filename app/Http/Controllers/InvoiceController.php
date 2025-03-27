<?php

namespace App\Http\Controllers;

use App\Models\invoice;
use App\Models\invoice_attachments;
use App\Models\invoice_details;
use App\Models\product;
use App\Models\section;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class InvoiceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $invoices = invoice::all();
        return view('invoices.index' , compact('invoices'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
       $sections = section::all();

        return view('invoices.create',compact('sections'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         $request->validate([
            'invoice_number' => 'required|string',
            'invoice_Date' => 'required|date',
            'Due_date' => 'date|nullable',
            'product' => 'required|string',
            'Section' => 'required|exists:sections,id',
            'Amount_collection' => 'required|numeric',
            'Amount_Commission' => 'required|numeric',
            'Discount' => 'required|numeric',
            'Value_VAT' => 'required|numeric',
            'Rate_VAT' => 'required|string',
            'Total' => 'required|numeric',
            'note' => 'nullable|string',
            'pic' => 'nullable|file|mimes:jpg,png,pdf|max:2048' 
        ]);
        
        $invoice_date = Carbon::createFromFormat('Y-m-d', $request->invoice_Date)->format('Y-m-d');
        $due_date = $request->Due_date ? Carbon::createFromFormat('Y-m-d', $request->Due_date)->format('Y-m-d') : null;

     
        invoice::create([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' =>$invoice_date ,
            'due_date' =>$due_date ,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_VAT' => $request->Value_VAT,
            'rate_VAT' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_Status' => 2,
            'note' => $request->note,
                 ]);

            $invoice_id = invoice::latest()->first()->id;
         invoice_details::create([
            'id_invoice' => $invoice_id,
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section_id' => $request->Section,
            'status' => 'غير مدفوعة',
            'value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
             ]);

             if ($request->hasFile('pic')) {

            $invoice_id = Invoice::latest()->first()->id;
            $image = $request->file('pic');
            $file_name = $image->getClientOriginalName();
            $invoice_number = $request->invoice_number;

            $attachments = new invoice_attachments();
            $attachments->file_name = $file_name;
            $attachments->invoice_number = $invoice_number;
            $attachments->Created_by = Auth::user()->name;
            $attachments->invoice_id = $invoice_id;
            $attachments->save();

            // move pic
            $imageName = $request->pic->getClientOriginalName();
            $request->pic->move(public_path('Attachments/' . $invoice_number), $imageName);
             }
            session()->flash('Add', 'تم اضافة الفاتورة بنجاح');
          return back();

    }

    /**
     * Display the specified resource.
     */
    public function show( $id)
    {
        
        $invoices = invoice::where('id', $id)->first();
        return view('invoices.status_update', compact('invoices'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit( $id)
    {
        $invoices= invoice::findOrFail($id);
        $sections= section::all();
        
        return view('invoices.edit',compact('invoices','sections'));

    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request,$id )
    {
        $invoice = invoice::findOrFail($id);
        $request->validate([
            'invoice_number' => 'required|string',
            'invoice_Date' => 'required|date',
            'Due_date' => 'date|nullable',
            'product' => 'required|string',
            'Section' => 'required|exists:sections,id',
            'Amount_collection' => 'required|numeric',
            'Amount_Commission' => 'required|numeric',
            'Discount' => 'required|numeric',
            'Value_VAT' => 'required|numeric',
            'Rate_VAT' => 'required|string',
            'Total' => 'required|numeric',
            'note' => 'nullable|string',
            'pic' => 'nullable|file|mimes:jpg,png,pdf|max:2048' 
        ]);
        
        $invoice_date = Carbon::createFromFormat('Y-m-d', $request->invoice_Date)->format('Y-m-d');
        $due_date = $request->Due_date ? Carbon::createFromFormat('Y-m-d', $request->Due_date)->format('Y-m-d') : null;

     
        invoice::where('id',$id)->update([
            'invoice_number' => $request->invoice_number,
            'invoice_Date' =>$invoice_date ,
            'due_date' =>$due_date ,
            'product' => $request->product,
            'section_id' => $request->Section,
            'amount_collection' => $request->Amount_collection,
            'amount_Commission' => $request->Amount_Commission,
            'discount' => $request->Discount,
            'value_VAT' => $request->Value_VAT,
            'rate_VAT' => $request->Rate_VAT,
            'total' => $request->Total,
            'status' => 'غير مدفوعة',
            'value_Status' => 2,
            'note' => $request->note,
                 ]);

            // $invoice_id = invoice::latest()->first()->id;
         invoice_details::where('id_invoice',$id)->update([
            'invoice_number' => $request->invoice_number,
            'product' => $request->product,
            'Section_id' => $request->Section,
            'status' => 'غير مدفوعة',
            'value_Status' => 2,
            'note' => $request->note,
            'user' => (Auth::user()->name),
             ]);

            
            session()->flash('edit', 'تم التعديل الفاتورة بنجاح');
          return back();
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request,$x)
    {
        $id = $request->invoice_id;
        $invoices = invoice::where('id', $id)->first();
        $Details = invoice_attachments::where('invoice_id', $id)->first();

         $id_page =$request->id_page;


        if (!$id_page==2) {

        if (!empty($Details->invoice_number)) {

            Storage::disk('public_uploads')->deleteDirectory($Details->invoice_number);
        }

        $invoices->forceDelete();
        session()->flash('delete_invoice');
        return redirect('/invoices');

        }

        else {

            $invoices->delete();
            session()->flash('archive_invoice');
            return redirect('/Archive');
        }

    
        

    }

    public function getproducts($id)
    {
        $status = DB::table('products')->where('section_id',$id)->pluck('product_name','id');
        return json_encode($status);

    }

    public function paid()
    {

        $invoice = invoice::where('value_status','1')->get();
        return view('invoices.paid',compact('invoice'));

    }

    public function unpaid()
    {

        
        $invoice = invoice::where('value_status','2')->get();
        return view('invoices.unpaid',compact('invoice'));

    }

    public function get_file($folder, $filename)

    {
        $filePath = $folder . '/' . $filename;
    
        if (!Storage::disk('public_uploads')->exists($filePath)) {
            abort(404, 'الملف غير موجود');
        }
        return response()->download(Storage::disk('public_uploads')->path($filePath));    }



    public function open_file($folder, $filename)
    {
        $filePath = $folder . '/' . $filename;
    
        if (!Storage::disk('public_uploads')->exists($filePath)) {
            abort(404, 'الملف غير موجود');
        }
    
        $file = Storage::disk('public_uploads')->path($filePath);
    
        return response()->file($file);
    }

    public function Status_Update($id, Request $request)
    {
        $invoices = invoice::findOrFail($id);

        if ($request->Status === 'مدفوعة') {

            $invoices->update([
                'value_status' => 1,
                'status' => $request->Status,
                'payment_date' => $request->Payment_Date,
            ]);

            invoice_Details::create([
                'id_Invoice' => $request->invoice_id,
                'invoice_number' => $request->invoice_number,
                'product' => $request->product,
                'section_id' => $request->Section,
                'status' => $request->Status,
                'value_status' => 1,
                'note' => $request->note,
                'payment_date' => $request->Payment_Date,
                'user' => (Auth::user()->name),
            ]);
        }
        session()->flash('Status_Update');
        return redirect('/invoices');

    }

}
