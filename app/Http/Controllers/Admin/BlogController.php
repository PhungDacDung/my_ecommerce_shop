<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Services\BlogService;
use App\Http\Services\Product\UploadService;
use Illuminate\Http\Request;

class BlogController extends Controller
{

    protected $upload;
    protected $blogService;

    public function __construct(UploadService $upload, BlogService $blogService)
    {
        $this->upload = $upload;
        $this->blogService = $blogService;
    }
    /**
     * Display a listing of the resource.
     */
    public function index()
    {

    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin/blog/addBlog',[
            'title' => 'Thêm mới bài viết',
        ]);
        
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // dd($request->input());
        $url = $this->upload->store($request);
        $this->blogService->insert($request,$url);
        return redirect()->back();

    }

    /**
     * Display the specified resource.
     */
    public function show()
    {
        
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function showDetail($id){
        $data = $this->blogService->getById($id);
        return view("pages/blog-detail",compact('data'));
    }
}
