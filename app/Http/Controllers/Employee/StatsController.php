<?php

namespace App\Http\Controllers\Employee;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Employee;
use DB;
class StatsController extends Controller
{

    public function department()
    {
        $stats = Employee::leftJoin('mst_departments as md', 'md.id', '=', 'employees.department_id')
        ->selectRaw("IFNULL(md.name, 'Undefined') AS department, COUNT(*) AS total")
        ->groupBy('department_id', 'md.name')
        ->get();

        return response()->json($stats);
    }
    public function status()
    {
        $stats = Employee::selectRaw("IFNULL(status, 'Undefined') AS status, COUNT(*) AS total")
            ->groupBy('status')
            ->get();
    
        // Hitung total keseluruhan
        $grandTotal = $stats->sum('total');
    
        // Tambahkan persentase ke setiap item
        $stats = $stats->map(function ($item) use ($grandTotal) {
            $item->percentage = $grandTotal > 0 
                ? round(($item->total / $grandTotal) * 100, 2) . '%' 
                : '0%';
            return $item;
        });
    
        return response()->json($stats);
    }

    public function join()
    {
        $stats = Employee::select(DB::raw('YEAR(join_date) as year'), DB::raw('count(*) as total'))
        ->groupBy('year')
        ->get();

        return response()->json($stats);
    }

    public function gender() {
        $maleCount = Employee::where('gender', 'male')->count();
        $femaleCount = Employee::where('gender', 'female')->count();
    
        return response()->json([
            'male' => $maleCount,
            'female' => $femaleCount,
        ]);
    }
}
