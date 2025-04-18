<?php

namespace App\Http\Controllers\Api;

use App\Models\Report;
use Illuminate\Http\Request;
use App\Http\Requests\ReportRequest;
use Illuminate\Http\Response;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReportResource;

class ReportController extends Controller
{
    /**
     * @group Report API
     * 
     * Get All Report
     */
    public function index(Request $request)
    {
        $reports = Report::paginate();

        return ReportResource::collection($reports);
    }

    /**
     * @group Report API
     * 
     * Store Report
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'reportedPerson' => 'required|string|max:255',
            'reason' => 'required|string|max:255',
            'date' => 'required|date',
            'description' => 'required|string',
        ]);

        Report::create([
            'reported_person' => $validated['reportedPerson'],
            'reason' => $validated['reason'],
            'user_id' => auth()->user()->id,
            'date' => $validated['date'],
            'description' => $validated['description'],
        ]);

        return response()->json(['message' => 'Report submitted successfully!', 'status' => 'success']);
    }


    /**
     * @group Report API
     * 
     * Show Report
     */
    public function show(Report $report): Report
    {
        return $report;
    }

     /**
     * @group Report API
     * 
     * Update Report
     */
    public function update(ReportRequest $request, Report $report): Report
    {
        $report->update($request->validated());

        return $report;
    }

    /**
     * @group Report API
     * 
     * Delete Report
     */
    public function destroy(Report $report): Response
    {
        $report->delete();

        return response()->noContent();
    }
}
