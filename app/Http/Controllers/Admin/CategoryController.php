<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    private $categoryRepository;

    public function __construct(CategoryRepository $categoryRepository)
    {
        $this->categoryRepository = $categoryRepository;
    }
    public function index()
    {
//      $categories=Category::orderBy('id','desc')->paginate(10);
        $categories=$this->categoryRepository->all();
        return view('admin.category.index',compact('categories'));
    }

    public function create()
    {
        return view('admin.category.create');
    }

    public function store(Request $request)
    {
        $inputs=$request->validate([
            'title'=>'required|string',
            'status'=>'required|in:0,1'

        ]);
//        Category::create($inputs);
        $this->categoryRepository->create($inputs);
        return redirect()->route('admin.category.index')->with('success', 'عملیات با موفقیت ثبت شد.');
    }

    public function edit(Category $category)
    {
        return view('admin.category.edit',compact('category'));

    }
    public function update(Request $request,Category $category)
    {
        $inputs=$request->validate([
            'title'=>'required|string',
            'status'=>'required|in:0,1'
        ]);
//        $category->update($inputs);
        $this->categoryRepository->updateById($category->id,$inputs);
        return redirect()->route('admin.category.index')->with('success', 'عملیات با موفقیت ثبت شد.');
    }

    public function destroy(Category $category)
    {
        $this->categoryRepository->deleteById($category->id);
        return redirect()->route('admin.category.index')->with('success', 'عملیات با موفقیت ثبت شد.');
    }

    public function status(Category $category)
    {
        $category->status=$category->status==0 ? 1 :0;
        $res=$category->save();

        if($res){
            if ($category->status==0){
                return response()->json(['status'=>true,'checked'=>false]);
            }else{
                return response()->json(['status'=>true,'checked'=>true]);
            }
        }
        else{
            return response()->json(['status'=>false]);
        }


    }
}
