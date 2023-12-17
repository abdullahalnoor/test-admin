<?php
 namespace App\Repositories\Product;

 interface ProductInterface
 {
 	  public function fetch();
 	  public function store($request);
 	  public function update($request,$category);
 	  public function destroy($category);
 }