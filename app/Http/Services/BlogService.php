<?php

namespace App\Http\Services;

use App\Models\Blog;

class BlogService{

    const LIMIT = 16;

    public function insert($request, $url){
        
            try{
                Blog::create([
                    'title' => (string)$request->input('title'),
                    'content' => (string)$request->input('content'),
                    'thumb' => (string)$url,
                ]);

                return redirect()->back()->with('success',"Thêm bài viết thành công");

            } catch(\Exception ){

                return redirect()->back()->with('error',"Thêm bài viết thất bại");
                return false;
            }

            return true;
    }

    
    public function get($page = null){
        return Blog::orderbyDesc('id')
        ->when($page != null, function($query) use ($page){
            $query->offset($page * self::LIMIT);
        })
        ->limit(self::LIMIT)
        ->get(); 
        
    }

    public function getById($id){
        return Blog::where('id','=',$id)->first();
    }



    public function update($request, $product, $url){
        
        $product->name = (string)$request->input('name');
        $product->description = (string)$request->input('description');
        $product->menu_id = (string)$request->input('menu_id');
        $product->content = (string)$request->input('content');
        $product->price = (string)$request->input('price');
        $product->price_sale = (string)$request->input('price_sale');
        $product->thumb = (string)$url;

        $product->save();

        return redirect()->back()->with('success','Sửa thông tin thành công');
        
        return true;
    }

    public function destroy($request){

       $id =(int)$request->input('id');
       
       $product = Blog::where('id',$id)->first();

       if($product){
            return Blog::where('id',$id)->delete();
       }
       return false;
    }
}