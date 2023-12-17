<?php
 namespace App\Repositories\Category;

 interface CategoryInterface
 {
 	  public function fetch();
 	  public function store($request);
 	  public function update($request,$category);
 	  public function destroy($category);
 }