<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

use App\Models\Employee\Experience;


class ExperienceController extends Controller
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
        $sort = !empty($request->sort) ? $request->sort : 'id';
        $sortDir = !empty($request->sortDir) ? $request->sortDir : 'desc';

        $query = Experience::when(!empty($request->search), function ($q, $search) {
            return $q->orWhere('name', 'LIKE', '%' . $search . '%');
        })
        ->when($request->employeeId, function($q, $search){
            $q->where('employee_id', $search);
        })
        ->orderBy($sort, $sortDir);

        if($request->limit){
            $data = $query->paginate($request->limit);
        }else{
            $data = $query->get();
        }
        return response()->json($data);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try{
            $data = new Experience();
            $data->employee_id = $request->employee_id;
            $data->title = $request->title;
            $data->company = $request->company;
            $data->location = $request->location;
            $data->from = $request->from;
            $data->to = $request->to;
            $data->description = $request->description;

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $fileName = time() . '_' . $file->getClientOriginalName();
                $filePath = 'uploads/' . $request->employee_id . '/experience/';
                $fileSize = $file->getSize(); // Get file size before moving
                $fileType = $file->getClientMimeType(); // Get file type before moving
                $file->move(public_path($filePath), $fileName);
                $data->file_path = '/' . $filePath . $fileName;
                $data->file_name = $fileName;
                $data->file_size = $fileSize;
                $data->file_type = $fileType;
            }

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
            $data = Experience::where('id', $id)->first();
            $data->employee_id = $request->employee_id;
            $data->title = $request->title;
            $data->company = $request->company;
            $data->location = $request->location;
            $data->from = $request->from;
            $data->to = $request->to;
            $data->description = $request->description;
            // Path lokasi penyimpanan gambar
            $filePath = 'uploads/employee/' . $request->employee_id . '/experience/';

            // Jika request image null tapi user memiliki gambar, hapus gambar lama
            if (is_null($request->file) && !empty($data->file_path)) {
                $oldImagePath = public_path($data->file_path);
                if (file_exists($oldImagePath)) {
                    unlink($oldImagePath); // Hapus file
                }
                $data->file_path = null;
                $data->file_name = null;
                $data->file_size = null;
                $data->file_type = null;
            }

            // Jika ada file gambar baru diunggah
            if ($request->hasFile('file')) {
                $file = $request->file('file');

                if (!empty($data->file_path)) {
                    $oldImagePath = public_path($data->file_path);
                    if (file_exists($oldImagePath)) {
                        unlink($oldImagePath); 
                    }
                }

                // Simpan file baru
                $fileName = time() . '_' . $file->getClientOriginalName();
                $file->move(public_path($filePath), $fileName);
                $data->file_path = '/' . $filePath . $fileName;
                $data->file_name = $fileName;
                $data->file_size = $fileSize;
                $data->file_type = $fileType;
            }
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

    public function destroy($id)
    {
        DB::beginTransaction();
        try{
            $data = Experience::where('id', $id)->first();
            if ($data->file_path && file_exists(public_path($data->file_path))) {
                unlink(public_path($data->file_path));
                unlink($data->file_path);
            }
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
