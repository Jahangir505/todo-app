<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CategoryController extends Controller
{
    public function index() {
        try {
            $categories = Category::orderBy('title')->get();

            return response()->json([
                'success' => true,
                'message' => "Category fetch successfully",
                'data' => $categories,
                'status_code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'status_code' => $e->getCode()
            ]);
        }
    }


    public function store(Request $request) {
        try {
            DB::beginTransaction();
//            return $request->all();
            $id = $request->input('id');

            if ($id > 0) {
                $category = Category::where('id', '=', $id)->first();
            } else{
                $category = new Category();
            }

            $category->title = $request->input('title');
            $category->save();
            DB::commit();
            if ($id > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Category Update Successfully',
                    'status_code' => 200
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Category Create Successfully',
                'status_code' => 200
            ]);
        } catch (Exception $e) {
            DB::rollback();
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'status_code' => $e->getCode()
            ]);
        }
    }

    public function delete($id) {
        try {

            if($id > 0) {
                $toto = Category::where('id', '=', $id)->first();
                $toto->delete();

                return response()->json([
                    'success' => true,
                    'message' => "Category delete successfully!",
                    'data' => null,
                    'status_code' => 200
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => "Category not found!",
                'data' => null,
                'status_code' => 200
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'data' => null,
                'status_code' => $e->getCode()
            ]);
        }
    }
}
