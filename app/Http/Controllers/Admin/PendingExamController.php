<?php

namespace App\Http\Controllers\Admin;

use App\Models\Exam;
use App\Models\Participant;
use App\Models\Area;
use App\Models\ExamSession;
use App\Models\Category;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
// use App\Http\Controllers\Category;
use Inertia\Inertia;

class PendingExamController extends Controller
{
    public function index()
    {
        // Get all areas for the filter dropdown
        $areas = Area::orderBy('title')->get();
        
        // Get unique witel values for the filter dropdown
        $witels = Participant::select('witel')->distinct()->whereNotNull('witel')->orderBy('witel')->pluck('witel');
        
        // Get unique role values for the filter dropdown
        $roles = Participant::select('role')->distinct()->whereNotNull('role')->orderBy('role')->pluck('role');
        
        // Get per_page parameter with default of 10
        $perPage = request('per_page', 10);
        
        // Check if we should show all records
        $shouldPaginate = $perPage !== 'all';
        
        $query = Participant::with(['area', 'grades.exam.category'])
            ->when(request('q'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('witel', 'like', "%{$search}%");
                });
            })
            ->when(request('area_id'), function($query, $areaId) {
                $query->where('area_id', $areaId);
            })
            ->when(request('witel'), function($query, $witel) {
                $query->where('witel', $witel);
            })
            ->when(request('role'), function($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy('created_at', 'DESC');
        
        // Either paginate or get all records
        $participants = $shouldPaginate 
            ? $query->paginate($perPage) 
            : $query->get()->toArray();
        
        // If showing all records, manually create a pagination-like structure
        if (!$shouldPaginate) {
            $participants = [
                'data' => $participants,
                'links' => [],
                'total' => count($participants),
                'per_page' => 'all',
                'current_page' => 1,
            ];
        }

        $categories = Category::orderBy('title')->get();

        return Inertia::render('Admin/PendingExams/Index', [
            'participants' => $participants,
            'categories' => $categories,
            'areas' => $areas,
            'witels' => $witels,
            'roles' => $roles,
            'filters' => request()->only(['q', 'area_id', 'witel', 'role', 'per_page'])
        ]);
    }

    public function export() // Changed from exportAll to export to match the route
    {
        // Get all areas for the filter dropdown
        $areas = Area::orderBy('title')->get();
        
        // Get unique witel values for the filter dropdown
        $witels = Participant::select('witel')->distinct()->whereNotNull('witel')->orderBy('witel')->pluck('witel');
        
        // Get unique role values for the filter dropdown
        $roles = Participant::select('role')->distinct()->whereNotNull('role')->orderBy('role')->pluck('role');
        
        // Same query as index but get all records instead of paginating
        $participants = Participant::with(['area', 'grades.exam.category'])
            ->when(request('q'), function($query, $search) {
                $query->where(function($q) use ($search) {
                    $q->where('name', 'like', "%{$search}%")
                      ->orWhere('nik', 'like', "%{$search}%")
                      ->orWhere('witel', 'like', "%{$search}%");
                });
            })
            ->when(request('area_id'), function($query, $areaId) {
                $query->where('area_id', $areaId);
            })
            ->when(request('witel'), function($query, $witel) {
                $query->where('witel', $witel);
            })
            ->when(request('role'), function($query, $role) {
                $query->where('role', $role);
            })
            ->orderBy('created_at', 'DESC')
            ->get();
    
        $categories = Category::orderBy('title')->get();
    
        return response()->json([
            'participants' => $participants,
            'categories' => $categories
        ]);
    }
}