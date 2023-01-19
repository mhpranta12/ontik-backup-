<?php

namespace App\Http\Controllers;

use Datatables;
use App\Models\Product;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Validator;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $products=Product::all();
        if($request->ajax())
        {
           $allData= DataTables::of($products)
           ->addIndexColumn()
           ->addColumn('action',function($row)
           {
            $btn='<a href="javascript:void(0)" data-toggle="tooltip" data-id="'.
            $row->id.'"data-original-title="Delete" class="btn btn-info"> Delete </a>';
            return $btn;   
           })
           ->rawColumns(['action'])
           ->mke(true);
           return $allData;
        }
       
        $subcategories=SubCategory::all();
        return view('product_list_ajax')->with('products',$products)->with('subcategories',$subcategories);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function product_list()
    {
        $joined = DB::table('products')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.subcategory_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->select('products.*', 'sub_categories.title as subCategory_title','categories.title as Category_title')
            ->paginate(5);
        $subcategories=SubCategory::all();
        $categories=Category::all();
        return view('product_list')->with('joined',$joined)->with('subcategories',$subcategories)->with('categories',$categories);
    }
    public function product_list_ajax()
    {
        $joined = DB::table('products')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.subcategory_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->select('products.*', 'sub_categories.title as subCategory_title','categories.title as Category_title')
            ->paginate(5);
        $subcategories=SubCategory::all();
        $categories=Category::all();
        return view('product_list_ajax_new')->with('joined',$joined)->with('subcategories',$subcategories)->with('categories',$categories);
    }
    public function addProduct(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|min:3|max:80',
            'description' => 'required|max:255',
            'thumbnail' => 'mimes:jpg,bmp,png|dimensions:min_width=100,min_height=200',
            'price' => 'required',
            'subcategory_id'=> 'required',
        ]);
        try
        {
        if($request->hasFile('thumbnail'))
        {
            $thumbnail = $request->file('thumbnail');
            $destination_path = 'public/thumbnail';
            $thumbnail_name = $thumbnail->getClientOriginalName();
            $path = $thumbnail->storeAs($destination_path,$thumbnail_name);
        }
        $product=new Product();
        $product->title=$request->title;
        $product->description=$request->description;
        $product->subcategory_id=$request->subcategory_id;
        $product->price=$request->price;
        $product->thumbnail=$thumbnail_name;
        $product->save();
        return redirect('/product_list')->with('success_message','Product Added Successfully');
        } 
        catch (\Exception $e) 
        {
            echo "Sorry an error occured of following :";
            dd($e);
        }
        
    }
    public function create()
    {
        
    }
    public function addProductPage()
    {
        $subcategories=SubCategory::all();
        return view('add_product')->with('subcategories',$subcategories);
    }
    public function filterProduct(Request $request)
    {
        $joined = DB::table('products')
            ->join('sub_categories', 'sub_categories.id', '=', 'products.subcategory_id')
            ->join('categories', 'categories.id', '=', 'sub_categories.category_id')
            ->select('products.*','categories.id as Category_ID','sub_categories.id as subCategory_ID', 'sub_categories.title as subCategory_title','categories.title as Category_title')
            ->get();
        $joined= $joined->where('title',$request->title)
        ->where('Category_ID',$request->category_id)
        ->where('subCategory_ID',$request->subcategory_id)
        ->whereBetween('price', [0,$request->price]) ;
        $count=$joined->count();
        $products=Product::all();
        $categories=Category::all();
        $subcategories=SubCategory::all();
        return view('found_product_list')->with('joined',$joined)->with('categories',$categories)->with('subcategories',$subcategories)->with('success_message','Products found')->with('count',$count);
    }
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        
        $validator=$request->validate([
            'title' => 'required|min:3|max:80',
            'description' => 'required|max:255',
            // 'thumbnail' => 'mimes:jpg,bmp,png|dimensions:min_width=100,min_height=200',
            'price' => 'required',
            'subcategory_id'=> 'required',
        ]);
        // if($validator->passess())
        // {
           
        // }
        // else
        // return response()->json(['error'=>'error occured']);

        $product=new Product();
        $product->title=$request->title;
        $product->description=$request->description;
        $product->subcategory_id=$request->subcategory_id;
        $product->price=$request->price;
        $product->thumbnail=$request->thumbnail;
        $product->save();
        return response()->json(['success'=>'Product Addedd']);
       
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product=Product::find($id);
        $product->delete();
        return redirect('/product_list');
    }
    public function delete($id)
    {
        $product=Product::find($id);
        $product->delete();
        return response()->json(['success'=>'Product Deleted']);
    }
    public function allProducts()
    {
        $products=Product::all();
        return response ()->json($products);
    }
}
