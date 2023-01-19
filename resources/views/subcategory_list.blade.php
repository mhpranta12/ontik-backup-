@extends('layouts.app');
@section('content')
<div class="container-fluid">

    <!-- Page Heading -->
    <h1 class="h3 mb-4 text-gray-800">Subcategory</h1>

    {{-- Form for adding products --}}
    <div class="container">
        <div class="row">
            <div class="col-md-6">
                <form action="" method="POST">
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
                    <div class="input-group">
                    <br>
                    <textarea class="form-control" name="description" id="description"required>
                    </textarea>
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
                   <br>
                   <button class="btn btn-info" type="submit">Add</button>
                   <br>
                   <br>
                </form>
                
            </div>
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
            <h5 class="card-title">Subcategory List</h5>
        </div>

        
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-bordered" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Description</th>
                            <th>Created At</th>
                            <th>Updated At</th>
                            <th>Action</th>
                        </tr>
                    </thead>
                    <tfoot>
                        
                    </tfoot>
                    <tbody>
                        @foreach ($subcategories as $subcategory)
                        <tr>
                          <td>{{$subcategory->title}}</td>
                            <td>{{$subcategory->description}}</td>
                            <td>{{$subcategory->created_at }}</td>
                            <td>{{$subcategory->updated_at}}</td>
                            <td>
                            <form action="{{ route('subcategories.destroy', $subcategory->id) }}" method="POST" class="d-inline">
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
                    {{ $subcategories->links() }}
                </div>
            </div>
        </div>
    </div>

</div>
@endsection
