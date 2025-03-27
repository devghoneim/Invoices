<?php

namespace App\Http\Controllers;

use App\Models\product;
use App\Models\section;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = product::all();
        $sections=section::all();
        
        return view('products.index',compact('data','sections'));
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
        $request->validate([
            'product_name'=>['required','string','max:50'],
            'section_id'=>['required','integer','exists:sections,id']
        ],
    ['product_name.required'=>'يرجى ادخال اسم المنتج',
        'product_name.string'=>'يجب المدخلات فى اسم المنتج تكون حروف',
        'product_name.max'=>'ادخلت فى اسم المنتج الحد الاقصى من الحروف',
        'section_id.required'=>'يرجى اختيار اسم القسم',
        'section_id.integer'=>'انت تقوم بتلاعب فى البيانات ',
        'section_id.exists'=>'قمت بتلاعب فى البيانات',

    ]);

        product::create([
            'product_name'=>$request->product_name,
            'section_id'=>$request->section_id,
            'description'=>$request->description,
            
        ]);
        return redirect()->back()->with('Add',"تم الاضافة المنتج بنجاح");
    }

    /**
     * Display the specified resource.
     */
    public function show(product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(product $product)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
        $request->validate([
            'product_name'=>['required','string','max:50'],
            'section_id'=>['required','integer','exists:sections,id']
        ],
    ['product_name.required'=>'يرجى ادخال اسم المنتج',
        'product_name.string'=>'يجب المدخلات فى اسم المنتج تكون حروف',
        'product_name.max'=>'ادخلت فى اسم المنتج الحد الاقصى من الحروف',
        'section_id.required'=>'يرجى اختيار اسم القسم',
        'section_id.integer'=>'انت تقوم بتلاعب فى البيانات ',
        'section_id.exists'=>'قمت بتلاعب فى البيانات',

    ]);


        $product = product::findOrFail($request->id);
        $product->product_name = $request->product_name;
        $product->section_id = $request->section_id;
        $product->description = $request->description;
        $product->save();
        return redirect()->back()->with('Add',"تم تعديل المنتج بنجاح");

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        product::findOrFail($request->id)->delete();
        return redirect()->back()->with('Add',"تم حذف المنتج بنجاح");

    }
}
