@extends('layouts.app');

@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<link href="https://fonts.googleapis.com/css?family=Nunito:200,200i,300,300i,400,400i,600,600i,700,700i,800,800i,900,900i"
        rel="stylesheet">

<div class="container-fluid">
    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Products (AJAX)</h1>
                
    <div class="row">
            <h4 class="modal-title" id="modalHeading">Add  Products</h4>
            {{-- <form action="" id="frm" method="POST" enctype="multipart/form-data"> --}}
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
                <div class="form-group">
                    <input type="text" name="title" id="title" class="form-control" required>
                </div><br>
                <label for="description">Description</label>
                <br>
                <textarea class="form-control" name="description" id="description" required>
                </textarea>
                <label for="price">Price</label>
                <div class="form-group">
                    <input type="number" name="price" id="price" class="form-control" required>
                </div>
                <label for="thumbnail">Thumbnail</label>
                <div class="form-group">
                    <input type="file" name="thumbnail" id="thumbnail" class="form-control" required>
                </div>
                <label for="subcategory">Subcategory</label>
                <div class="form-group">
                    <select class="form-select form-control" name="subcategory_id" id="subcategory_id" required>
                        <option>Select Subcategory</option>
                        @foreach ($subcategories as $subcategory)
                        @if ($subcategory!=null)
                            <option value="{{$subcategory->id}}">{{$subcategory->title}}</option>
                        @endif
                        @endforeach>
                    </select>
                </div>
               <br>
               <br>
               <br>
               <button type="submit" id="addBtn" class="btn btn-md btn-success" onclick="addProduct()">Add Product</button>
               <br>
               <br>
            {{-- </form> --}}
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
                       {{-- Here will be the ajax's provided table  --}}
                    </tbody>
                </table>
                <div class="row">
                    {{ $joined->links()  }}
                </div>
            </div>
        </div>
    </div>
</div>
<script src="https://code.jquery.com/jquery-3.6.3.min.js" integrity="sha256-pvPw+upLPUjgMXY0G+8O0xUf+/Im1MZjXxxgOcBQBXU=" crossorigin="anonymous"></script>
<script>
    function allProducts()
    {
        $.ajax({
            type:"GET",
            dataType:'json',
            url:"/products/all",
            success:function(response)
            {
                var data=" ";
                $.each(response,function(key,value)
                {
                    data= data + "<tr>"
                    data= data + "<td>"+value.title+"</td>"
                    data= data + "<td>"+value.thumbnail+"</td>"
                    data= data + "<td>"+value.description+"</td>"
                    data= data + "<td>"+value.subcategory_id+"</td>"
                    data= data + "<td>"+value.price+"</td>"
                    data= data + "<td>"+value.created_at+"</td>"
                    data= data + "<td>"+value.updated_at+"</td>"
                    data= data + "<td>"
                    data= data + "<button class='btn btn-danger' onclick='deleteProduct("+value.id+")'> Delete </button>"
                    data= data + "</td>"
                    data= data + "</tr>"
                })
                $('tbody').html(data);
            }
        })
    }
    allProducts();
    function clearData()
    {
        $('#title').val('');
        $('#description').val('');
        $('#price').val('');
        $('#thumbnail').val('');
        $('#subcategory_id').val('');
    }
    function addProduct()
    {
        var title = $('#title').val();
        var description =$('#description').val();
        var price = $('#price').val();
        var thumbnail =$('#thumbnail').val();
        var subcategory_id =$('#subcategory_id').val();
       $.ajax({
        type:"POST",
            dataType:'json',
            data : {title:title,description:description,price:price,thumbnail:thumbnail,subcategory_id:subcategory_id},
            url:"/products/store",
            success:function(data)
            {
                allProducts();
                clearData();
                const msg= Swal.mixin({
                    position: 'top-end',
                    icon: 'success',
                    
                    showConfirmButton: false,
                    timer: 1500
                })
                msg.fire({
                    type: 'success',
                    title: 'Product Added',
                })
            }
       })
    }
    // function deleteProduct(id)
    // {
    //     $.ajax({
    //         type:"GET",
    //         dataType:'json',
    //         url:"/products/delete/"+id,
    //         alert("deleted");
    //     })
    // }
</script>
<script>
    $.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});
</script>
{{-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script> --}}
@endsection
