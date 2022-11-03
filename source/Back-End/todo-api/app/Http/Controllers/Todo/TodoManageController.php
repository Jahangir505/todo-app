<?php

namespace App\Http\Controllers\Todo;

use App\Http\Controllers\Controller;
use App\Models\Todo;
use Exception;
use Illuminate\Http\Request;

class TodoManageController extends Controller
{
    public function index() {
        try {
            $todo_list = Todo::all();

            return response()->json([
                'success' => true,
                'message' => "Todo fetch successfully",
                'data' => $todo_list,
            ]);
        } catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'status_code' => $e->getCode()
            ]);
        }
    }

    public function todoListByCategory(Request $request) {
        try {
            $id = $request->input('id');
            $todo_list = Todo::where('cat_id', '=', $id)->get();

            return response()->json([
                'success' => true,
                'message' => "Todo fetch successfully",
                'data' => $todo_list,
            ]);
        }catch (Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
                'status_code' => $e->getCode()
            ]);
        }
    }


    public function store(Request $request) {
        try {
            $id = $request->input('id');

            if ($id > 0) {
                $todo = Todo::where('id', '=', $id)->first();
            }else{
                $todo = new Todo();
            }

            $todo->title = $request->input('title');
            $todo->description = $request->input('description');
            $todo->cat_id = (int)$request->input('catId');
            $todo->save();

            if ($id > 0) {
                return response()->json([
                    'success' => true,
                    'message' => 'Todo Update Successfully',
                    'status_code' => 200
                ]);
            }

            return response()->json([
                'success' => true,
                'message' => 'Todo Create Successfully',
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

    public function delete($id) {
        try {

            if($id > 0) {
                $toto = Todo::where('id', '=', $id)->first();
                $toto->delete();

                return response()->json([
                    'success' => true,
                    'message' => "Todo delete successfully!",
                    'data' => null,
                    'status_code' => 200
                ]);
            }
            return response()->json([
                'success' => false,
                'message' => "Todo not found!",
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
