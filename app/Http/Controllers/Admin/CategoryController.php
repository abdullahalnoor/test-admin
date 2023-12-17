<?php

namespace App\Http\Controllers\Admin;


use App\Models\Category;


use App\Http\Requests\StoreCategoryRequest;
use App\Http\Requests\UpdateCategoryRequest;

use App\Repositories\Category\CategoryInterface;

use DataTables;
use DB;

use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class CategoryController extends Controller
{

    protected $category;
    public function __construct(CategoryInterface $category)
    {
        // $this->middleware('auth_check');
        $this->category = $category;
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {  
       
        // return view('backend.category.index');
        DB::beginTransaction();
        try
        {
            if($request->ajax()) {
                $categories = $this->category->fetch();

                return Datatables::of($categories)
                        ->addIndexColumn()
                       


                       
                        // ->orderColumn('name', '-name $1')
                       
                        ->addColumn('image', function($row){
                            $url= asset($row->image);
                               return '<img alt="Image" src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';
                              
                         })
                        ->addColumn('action', function($row){
                                                        
                           $btn = "";
                            $btn .= '&nbsp;';
                            $btn .= ' <a href="'.route('admin.category.edit',$row->id).'" class="btn btn-primary btn-sm m-1 action-button edit-category" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                            $btn .= '&nbsp;';


                              $btn .= ' <a href="#" class="btn btn-danger btn-sm m-1 delete-category action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>'; 
        
                          
        
                                return $btn;
                        })
                        ->rawColumns(['image','action'])
                        
                        ->make(true); 
            }
            DB::commit(); 
            return view('admin.category.index');
        }catch(Exception $e){
                  
                DB::rollback();
             \Log::error('Exception caught: ' . $e->getMessage()); 
             return false;
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.category.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCategoryRequest $request)
    {
        DB::beginTransaction();
        try
        {
           $this->category->store($request);
            DB::commit();
            $notification=array(
                'messege'=>'Successfully user has been added',
                'alert-type'=>'success'
               );
            return redirect()->back()->with($notification); 
           
        }catch(Exception $e){
                  
                DB::rollback();
             \Log::error('Exception caught: ' . $e->getMessage()); 
             return false;
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        return view('admin.category.edit',\get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateCategoryRequest $request, Category $category)
    {
        DB::beginTransaction();
        try
        {
           $this->category->update($request,$category);
            DB::commit();
            $notification=array(
                'messege'=>'Successfully user has been updated',
                'alert-type'=>'success'
               );
            return redirect()->route('admin.category.index')->with($notification); 
            return redirect()->back()->with($notification); 
           
        }catch(Exception $e){
                  
                DB::rollback();
             \Log::error('Exception caught: ' . $e->getMessage()); 
             return false;
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
    }
}
