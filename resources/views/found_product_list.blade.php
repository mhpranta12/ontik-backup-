@extends('layouts.app');

@section('content')
<link
        href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet">
    
    <link href="https://cdn.datatables.net/1.10.16/css/jquery.dataTables.min.css" rel="stylesheet">

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Products</h1>
                {{-- CDN of Jquery  --}}
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer">
                </script>
                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer">
                </script>
            {{-- </div>
        </div>
    </div>  --}}
    {{-- <button class="btn btn-info" type="submit" id="addProduct">Add</button> --}}
    <div class="row">
            <h4 class="modal-title" id="modalHeading">Filter Products</h4>
            <form action="" id="frm" method="POST" enctype="multipart/form-data">
                @csrf
                <label for="title">Title</label>
                <div class="input-group">
                    <input type="text" name="title" id="title" class="form-control" required>
                </div><br>
                <div class="input-group">
                <br>
                </div>
                <label for="price">Price (1-10000)৳ </label>
                <div class="input-group w-25">
                    <input type="range" class="form-range" id="points" name="price" min="0" max="10000">
                </div>
                <label for="category">Category</label>
                <div class="input-group">
                    <select class="form-select form-control" name="category_id" id="category" required>
                        <option>Select Category</option>
                        @foreach ($categories as $category)
                        @if ($category!=null)
                            <option value="{{$category->id}}">{{$category->title}}</option>
                        @endif
                        @endforeach>
                    </select>
                </div>
                <label for="subcategory">Subcategory</label>
                <div class="input-group">
                    <select class="form-select form-control" name="subcategory_id" id="thumbnail" required>
                        <option>Select Subcategory</option>
                        @foreach ($subcategories as $subcategory)
                        @if ($subcategory!=null)
                            <option value="{{$subcategory->id}}">{{$subcategory->title}}</option>
                        @endif
                        @endforeach>
                    </select>
                </div>
               <br>
               <button class="btn btn-md btn-info" type="submit" id="addBtn">Filter</button>
               <br>
               <br>
            </form>
    </div>
</div>
    @if (session('message'))
        <div class="alert alert-primary" role="alert">
            {{ session('message') }}
        </div>
    @endif
    @if (session('success_message'))
    <div class="alert alert-success" role="alert">
        {{ session('success_message') }}
    </div>
    @endif
    @if ($count==0)
    <div class="alert alert-danger" role="alert">
        No records found
    </div>
    @else
    <div class="alert alert-success" role="alert">
        {{ $count }} records found
    </div>
    @endif
    <div class="card shadow mb-4">
        <div class="card-header d-flex justify-content-between pt-4">
            <h5 class="card-title">Products List</h5>
        </div>
        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered data-table" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Thumbnail</th>
                            <th>Description</th>
                            <th>Category</th>
                            <th>Subcategory</th>
                            <th>Price</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        
                    </tfoot>
                    <tbody>
                        @foreach ($joined as $combined)
                        <tr>
                            <td>{{$combined->title}}</td>
                            <td>
                            <img src="{{ asset('/storage/thumbnail/' . $combined->thumbnail) }}" alt="image of users" height="100" width="100" />

                            </td>
                            <td>{{$combined->description}}</td>
                            <td>{{$combined->Category_title}}</td>
                            <td>{{$combined->subCategory_title}}</td>
                            <td>{{$combined->price}}৳</td>
                            <td>{{$combined->created_at }}</td>
                            <td>{{$combined->updated_at}}</td>
                            
                            <td>
                                <form action="{{ route('products.destroy', $combined->id) }}" method="POST" class="d-inline">
                                    @csrf
                                    @method('DELETE')
                                    <button class="btn btn-info" type="submit"><img src="{{ asset('icon/cross.png') }}" alt="" height="20" weight="20"></button>
                                </form> 
                            </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
                <div class="row">
                    {{-- {{ $joined->links()  }} --}}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
