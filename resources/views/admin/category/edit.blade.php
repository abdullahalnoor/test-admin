@extends('admin.app')

@section('page_title')
Edit  Category
@endsection


@push('styles')
  <!-- Select2 -->
  <link rel="stylesheet" href="{{asset('assets/admin/plugins/select2/css/select2.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/plugins/select2-bootstrap4-theme/select2-bootstrap4.min.css')}}">
  <link rel="stylesheet" href="{{asset('assets/admin/plugins/dropify/dist/css/dropify.min.css')}}">
@endpush

@section('content')
<div class="content-wrapper" style="min-height: 1345.31px;">
    <!-- Content Header (Page header) -->
    <section class="content-header">
      <div class="container-fluid">
        <div class="row mb-2">
          <div class="col-sm-6">
            <h1>Create  Category</h1>
          </div>
          <div class="col-sm-6">
            <ol class="breadcrumb float-sm-right">
              <li class="breadcrumb-item"><a href="#">Home</a></li>
              <li class="breadcrumb-item active">Create  Category</li>
            </ol>
          </div>
        </div>
      </div><!-- /.container-fluid -->
    </section>

    <!-- Main content -->
    <section class="content">
      <div class="container-fluid">
        <div class="row">
          <!-- left column -->
          <div class="col-md-12">
            <!-- general form elements -->
            <div class="card card-primary">
              <!-- <div class="card-header">
                <h3 class="card-title">Quick Example</h3>
              </div> -->
              <!-- /.card-header -->
              <!-- form start -->
              <form action="{{route('admin.category.update',$category->id)}}" method="POST"  enctype="multipart/form-data">
                @csrf
                @method('PUT')
              <div class="card-body">
                  
                <div class="form-group">
                    <label for="name">Name <span class="text-danger">*</span></label>
                    <input type="text" class="form-control" name="name" id="name" value="{{old('name',$category->name)}}" placeholder="Enter Name">
                    @error('name')
				      <span class=" text-danger"><b>{{ $message }}</b></span>
		           @enderror 
                </div>
                 
                  <div class="form-group">
                  <label>Status</label>
                  <select name="status" class="form-control select2bs4" style="width: 100%;">
            
                    <option value="1"  {{$category->status == 1 ? 'selected' : ''}} >Active</option>
                    <option value="2"  {{$category->status == 2 ? 'selected' : ''}}>Inactive</option>
                  </select>
                  @error('status')
				      <span class=" text-danger"><b>{{ $message }}</b></span>
		           @enderror 
                </div>
                 
                <div class="row">
               
                  <div class="col-md-6 text-center d-flex justify-content-center aling-items-center">
                  <!-- <label for="name">Image </label> -->
                  <img src="{{asset($category->image)}}" width="100%" height="250" alt="Image" srcset="">
                  </div>
                  <div class="col-md-6">
                  <div class="form-group">
                  <!-- <label for="name">Upload </label> -->
                    <input type="file"  name="image" class="dropify" data-height="250" />
                    @error('image')
				      <span class=" text-danger"><b>{{ $message }}</b></span>
		           @enderror 
                </div>


                  </div>
                </div>
                


               

                </div>
                <!-- /.card-body -->

                <div class="card-footer">
                  <button type="submit" class="btn btn-primary">Submit</button>
                </div>
              </form>
            </div>
            <!-- /.card -->

            
          

          </div>
          <!--/.col (left) -->
        
        </div>
        <!-- /.row -->
      </div><!-- /.container-fluid -->
    </section>
    <!-- /.content -->
  </div>
@endsection


@push('scripts')
<!-- Select2 -->
<script src="{{asset('assets/admin/plugins/select2/js/select2.full.min.js')}}"></script>
<script src="{{asset('assets/admin/plugins/dropify/dist/js/dropify.min.js')}}"></script>

<script>
$(function () {
    //Initialize Select2 Elements
    $('.select2').select2()

    //Initialize Select2 Elements
    $('.select2bs4').select2({
      theme: 'bootstrap4'
    })

    $('.dropify').dropify();
}); 
</script>

@endpush