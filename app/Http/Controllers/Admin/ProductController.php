<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Menu\CreateFormRequest;
use App\Http\Services\Menu\MenuService;
use App\Http\Services\Product\ProductService;
use App\Http\Services\Product\UploadService;
use Illuminate\Http\Request;
use  App\Http\Requests\Product\ProductRequest;
use App\Models\Product;
use Illuminate\Http\JsonResponse;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    protected $upload;
    protected $menuService;
    protected $productService;

    public function __construct(UploadService $upload, MenuService $menuService, ProductService $productService)
    {
        $this->upload = $upload;
        $this->menuService = $menuService;
        $this->productService = $productService;
    }

    public function index()
    {
        return view('admin/product/listProduct',[
            'title' => 'Danh sách sản phẩm',
            'products' => $this->productService->get(),
        ]);

        
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/product/addProduct',[
            'title' => 'Thêm sản phẩm',
            'menus' => $this->menuService->getParent()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductRequest $request)
    {
       $url = $this->upload->store($request);

       $this->productService->insert($request,$url);
       
       return redirect()->back();
    }

    /**
     * Display the specified resource.
     */
    public function show(Product $product)
    {
        return view('admin/product/editProduct',[
            'title' => 'Sửa thông tin sản phẩm',
            'product' => $product,
            'menus' => $this->menuService->getParent()

        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(ProductRequest $request,Product $product)
    {
        $url = $this->upload->store($request);
        $this->productService->update($request, $product, $url);
        
        return redirect('admin/product/list');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request): JsonResponse
    {
        $result = $this->productService->destroy($request);
        
        if($result){
            return response()->json([
                'error' =>false,
                'message' => 'Xóa thành công'
            ]);
        }
        return response()->json([
            'error' => true,
        ]);
    }

   
    /* Product home page */
    public function showDetail($id){
        $data = $this->productService->getById($id);
        return view("pages/product-detail",compact('data'));
    }

    public function productPage(){
        return view('pages/product',[
            'title' => 'Sanr phẩm',
            'products' => $this->productService->get(),
        ]);
    }
}
