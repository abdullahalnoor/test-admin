<?php

namespace App\Http\Controllers\Admin;

use App\Models\Category;
use App\Models\Product;

use App\Http\Requests\StoreProductRequest;
use App\Http\Requests\UpdateProductRequest;

use App\Repositories\Product\ProductInterface;

use DataTables;
use DB;


use  App\Http\Controllers\Controller;
use Illuminate\Http\Request;



class ProductController extends Controller
{
    protected $product;
    public function __construct(ProductInterface $product)
    {
        // $this->middleware('auth_check');
        $this->product = $product;
    }
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        DB::beginTransaction();
        try
        {
            if($request->ajax()) {
                $products = $this->product->fetch();

                return Datatables::of($products)
                        ->addIndexColumn()
                       
                        // ->orderColumn('name', '-name $1')
                       
                        ->addColumn('image', function($row){
                            $url= asset($row->image);
                               return '<img alt="Image" src="'.$url.'" border="0" width="40" class="img-rounded" align="center" />';
                              
                         })
                        ->addColumn('action', function($row){
                                                        
                           $btn = "";
                            $btn .= '&nbsp;';
                            $btn .= ' <a href="'.route('admin.product.edit',$row->id).'" class="btn btn-primary btn-sm m-1 action-button edit-product" data-id="'.$row->id.'"><i class="fa fa-edit"></i></a>';

                            $btn .= '&nbsp;';


                              $btn .= ' <a href="#" class="btn btn-danger btn-sm m-1 delete-product action-button" data-id="'.$row->id.'"><i class="fa fa-trash"></i></a>'; 
        
                          
        
                                return $btn;
                        })
                        ->rawColumns(['image','action'])
                        
                        ->make(true); 
            }
            DB::commit(); 
            // return 1;
            return view('admin.product.index');
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
        $categories = Category::where('status',1)->get();
        return view('admin.product.create',\get_defined_vars());
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductRequest $request)
    {
        DB::beginTransaction();
        try
        {
           $this->product->store($request);
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
    public function show(Product $product)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Product $product)
    {
        // return $product->categories;
        $categories = Category::where('status',1)->get();
        return view('admin.product.edit',\get_defined_vars());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProductRequest $request, Product $product)
    {
        DB::beginTransaction();
        try
        {
           $this->product->update($request,$product);
            DB::commit();
            $notification=array(
                'messege'=>'Successfully user has been updated',
                'alert-type'=>'success'
               );
            // return redirect()->route('admin.product.index')->with($notification); 
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
    public function destroy(Product $product)
    {
        //
    }
}
