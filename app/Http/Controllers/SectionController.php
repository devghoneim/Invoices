<?php

namespace App\Http\Controllers;

use App\Models\section;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class SectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $data = section::all();
        return view('sections.index',compact('data'));
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
            'section_name'=>['required','string','max:50','unique:sections,section_name'],
            
        ],[
            'section_name.required'=>'يرجى ادخال اسم القسم',
            'section_name.string'=>'ادخل حروف فقط فى خانة اسم القسم',
            'section_name.max'=>'لقد تعديت الحجم الحروف المطلوب فى خانة اسم القسم',
            'section_name.unique'=>'اسم القسم موجود بالفعل ',
            
        ]
    
    );
       
        
            section::create([
                'section_name'=>$request->section_name,
                'description'=>$request->description,
                'created_by'=>Auth::user()->name,
            ]);
            // session()->flash('Add',"تم اضافة بنجاح");
            
        
        return redirect()->back()->with('Add',"تم اضافة القسم بنجاح");
    }

    /**
     * Display the specified resource.
     */
    public function show(section $section)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(section $section)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request)
    {
       $check = section::findOrFail($request->id);
       $request->validate([
        'section_name'=>['required','string','max:50','unique:sections,section_name'],
        
    ],[
        'section_name.required'=>'يرجى ادخال اسم القسم',
        'section_name.string'=>'ادخل حروف فقط فى خانة اسم القسم',
        'section_name.max'=>'لقد تعديت الحجم الحروف المطلوب فى خانة اسم القسم',
        'section_name.unique'=>'اسم القسم موجود بالفعل ',
        
    ]

        );

        section::where('id',$request->id)->update([
            "section_name"=>$request->section_name,
            "description"=>$request->description,
        ]);
        return redirect()->back()->with('Edit','تم التعديل بنجاح');

    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        $id = $request->id;
        section::findOrFail($id)->delete();
        return redirect()->back()->with('Delete','تم الحذف القسم بنجاح');
    }
}
