<?php

namespace App\Http\Controllers\Settings;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Pagination\LengthAwarePaginator;

use App\Models\Settings\Department;


class DepartmentController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // dd($request->all());
        Department::fixTree();
        $sort = !empty($request->sort) ? $request->sort : 'id';
        $sortDir = !empty($request->sortDir) ? $request->sortDir : 'desc';

        $query = Department::when(!empty($request->search), function ($q, $search) {
            return $q->orWhere('name', 'LIKE', '%' . $search . '%');
        })
        // ->when($request->tree, function($q){
        //     return $q->whereNull('parent_id')
        //     ->with(['children' => function($q2){
        //         $q2->with(['children' => function ($q3){
        //             $q3->with('children');
        //         }
        //         ]);
        //     }]);
        // })
        ->withCount('employee')
        ->when(!isset($request->tree), function($q){
            $q->orderBy($sort, $sortDir);
        });

        if($request->limit){
            if($request->tree){
                $allData = $query->withDepth()->get()->toTree();$currentPage = LengthAwarePaginator::resolveCurrentPage();
                
                $perPage = $request->limit;
                $currentItems = $allData->slice(($currentPage - 1) * $perPage, $perPage);
                $data = new LengthAwarePaginator(
                    $currentItems,
                    $allData->count(),
                    $perPage,
                    $currentPage,
                    ['path' => LengthAwarePaginator::resolveCurrentPath()]
                );
            }else{
                $data = $query->paginate($request->limit);
            }
        }else{
            if($request->tree){
                $data = $query->withDepth()->get()->toTree();
            }else{
                $data = $query->get();
            }
        }
        // $data = Department::withDepth()->get()->toTree();

        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = new Department();
            $data->name = $request->name;
            $data->code = $request->code;
            $data->parent_id = $request->parent_id;
            $data->save();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'result' => $e,
            ], 422);
        }
        DB::commit();
        return response()->json([
            'success' => true,
        ], 200);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        DB::beginTransaction();
        try{
            $data = Department::where('id', $id)->first();
            $data->name = $request->name;
            $data->code = $request->code;
            $data->parent_id = $request->parent_id;
            $data->save();

            Department::fixTree();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'result' => $e,
            ], 422);
        }
        DB::commit();
        return response()->json([
            'success' => true,
        ], 200);
    }

    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data = Department::where('id', $id)->first();
            $data->delete();

        }catch(\QueryException $e){
            DB::rollback();
            return response()->json([
                'success' => false,
                'result' => $e,
            ], 422);
        }
        DB::commit();
        return response()->json([
            'success' => true,
        ], 200);
    }
    
}
