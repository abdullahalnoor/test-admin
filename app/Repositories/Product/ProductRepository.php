<?php 
namespace App\Repositories\Product;
use App\Models\Category;
use App\Models\Product;
use App\Repositories\Product\ProductInterface;
use DB;
use Auth;
class ProductRepository implements ProductInterface
{
     public function fetch()
     {
     	 DB::beginTransaction();
 	 	 try
 	 	 {  
 	 	 	$products = Product::orderBy('id','desc')->get();
 	 	 	DB::commit();
 	 	 	return $products;
 	 	 }catch(Exception $e){
 	 	 	DB::rollback();
    
		    \Log::error('Exception caught: ' . $e->getMessage());
		    
		    return false;
 	 	 }
     }

     public function store($request)
     {   
     	 DB::beginTransaction();
     	 try
 	 	 {  
 	 	 	// Category::create([
 	 	 	// 	'user_id' => Auth::user()->id,
 	 	 	// 	'category_name' => $request->category_name,
 	 	 	// ]);
			$product = new Product();
			$path = null;
			$link = null;
			if($request->hasFile('image')){
                // @unlink(public_path() . '/' .$this->publicImagePath.$product->image);
                $image = $request->file('image');
                $imageName = uniqid().time().'.'.$image->getClientOriginalExtension();
                $path = 'uploads/images/product-image/';
                $link  = $path.$imageName;
                $product->image = $link;
            }
            
            // $product->user_id = auth()->user()->id;
			// $product->user_id = Auth::user()->id;
			$product->user_id = 1;
            $product->name = $request->name;
			$product->description = $request->description;
            $product->status = $request->status;
            $product->save();
			$product->categories()->attach($request->category);
			


			if($request->hasFile('image')){
                if (! file_exists(public_path($path))) {
                    mkdir(public_path($path), 0777, true);
                }  
                $image->move(public_path().'/'.$path,$imageName);
            }


 	 	 	DB::commit();
 	 	 	return true;
 	 	 }catch(Exception $e){
 	 	 	DB::rollback();
    
		    \Log::error('Exception caught: ' . $e->getMessage());
		    
		    return false;
 	 	 }
     }

     public function update($request, $product)
     {      
		DB::beginTransaction();
		try
		 {  
			 // Category::create([
			 // 	'user_id' => Auth::user()->id,
			 // 	'category_name' => $request->category_name,
			 // ]);
		  $path = null;
		  $link = null;
		  if($request->hasFile('image')){
			  // @unlink(public_path() . '/' .$this->publicImagePath.$product->image);
			  @unlink(public_path() . '/' .$product->image);
			  $image = $request->file('image');
			  $imageName = uniqid().time().'.'.$image->getClientOriginalExtension();
			  $path = 'uploads/images/product-image/';
			  $link  = $path.$imageName;
			  $product->image = $link;
		  }
		  
		  // $product->user_id = auth()->user()->id;
		  // $product->user_id = Auth::user()->id;
		  $product->user_id = 1;
		  $product->name = $request->name;
		  $product->description = $request->description;
		  $product->status = $request->status;
		  $product->update();
		  $product->categories()->sync($request->category);


		  if($request->hasFile('image')){
			
			  if (! file_exists(public_path($path))) {
				  mkdir(public_path($path), 0777, true);
			  }  
			  $image->move(public_path().'/'.$path,$imageName);
		  }


			 DB::commit();
			 return true;
		 }catch(Exception $e){
			 DB::rollback();
  
		  \Log::error('Exception caught: ' . $e->getMessage());
		  
		  return false;
		 }
     }

     public function destroy($category)
     {
     	  DB::beginTransaction();
 	 	 try
 	 	  {
 	 	  	  $category->delete();
 	 	  	  DB::commit();
 	 	  	  return true;
 	 	  }catch(Exception $e){
 	 	 	DB::rollback();
    
             \Log::error('Exception caught: ' . $e->getMessage());
    
              return false;
 	 	 }
     }
}