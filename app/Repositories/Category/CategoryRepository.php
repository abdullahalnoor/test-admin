<?php 
namespace App\Repositories\Category;
use App\Models\Category;
use App\Repositories\Category\CategoryInterface;
use DB;
use Auth;
class CategoryRepository implements CategoryInterface
{
     public function fetch()
     {
     	 DB::beginTransaction();
 	 	 try
 	 	 {  
 	 	 	$categories = Category::orderBy('id','desc')->get();
 	 	 	DB::commit();
 	 	 	return $categories;
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
			$category = new Category();
			$path = null;
			$link = null;
			if($request->hasFile('image')){
                // @unlink(public_path() . '/' .$this->publicImagePath.$category->image);
                $image = $request->file('image');
                $imageName = uniqid().time().'.'.$image->getClientOriginalExtension();
                $path = 'uploads/images/category-image/';
                $link  = $path.$imageName;
                $category->image = $link;
            }
            
            // $category->user_id = auth()->user()->id;
			// $category->user_id = Auth::user()->id;
			$category->user_id = 1;
            $category->name = $request->name;
            $category->status = $request->status;
            $category->save();



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

     public function update($request, $category)
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
			  // @unlink(public_path() . '/' .$this->publicImagePath.$category->image);
			  @unlink(public_path() . '/' .$category->image);
			  $image = $request->file('image');
			  $imageName = uniqid().time().'.'.$image->getClientOriginalExtension();
			  $path = 'uploads/images/category-image/';
			  $link  = $path.$imageName;
			  $category->image = $link;
		  }
		  
		  // $category->user_id = auth()->user()->id;
		  // $category->user_id = Auth::user()->id;
		  $category->user_id = 1;
		  $category->name = $request->name;
		  $category->status = $request->status;
		  $category->update();



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