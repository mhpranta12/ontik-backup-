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

    {{-- Form for adding products --}}
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                            <form action="" id="frm" method="POST" enctype="multipart/form-data">
                                @csrf
                                @if ($errors->any())
                                <div class="alert alert-danger">
                                    <ul>
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                                @endif
                                <label for="title">Title</label>
                                <div class="input-group">
                                    <input type="text" name="title" id="title" class="form-control" required>
                                </div><br>
                                <label for="description">Description</label>
                                <br>
                                <textarea class="form-control" name="description" id="description" required>
                                </textarea>
                                <label for="price">Price</label>
                                <div class="input-group">
                                    <input type="number" name="price" class="form-control" required>
                                </div>
                                <label for="thumbnail">Thumbnail</label>
                                <div class="input-group">
                                    <input type="file" name="thumbnail" class="form-control" required>
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
                               <button class="btn btn-md btn-info" type="submit" id="addBtn">Add Product</button>
                               <br>
                               <br>
                            </form>
                {{-- CDN of Jquery  --}}
                <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/1.9.1/jquery.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer">
                </script>

                <script src="https://cdn.datatables.net/1.12.1/js/jquery.dataTables.min.js" integrity="sha512-aVKKRRi/Q/YV+4mjoKBsE4x3H+BkegoM/em46NNlCqNTmUYADjBbeNefNxYV7giUp0VxICtqdrbqU7iVaeZNXA==" crossorigin="anonymous" referrerpolicy="no-referrer">
                </script>
            </div>
        </div>
    </div>
    </div>
</div>
@endsection
