<?php

namespace App\Http\Controllers;

use App\Models\CallLog;
use Illuminate\Http\Request;

class CallLogController extends Controller
{
    public function index(Request $request)
    {
        $query = CallLog::query();

        // Optional filters
        if ($request->filled('from_no')) {
            $query->where('from_no', 'like', '%' . $request->from_no . '%');
        }

        if ($request->filled('to_no')) {
            $query->where('to_no', 'like', '%' . $request->to_no . '%');
        }

        if ($request->filled('status')) {
            $query->where('reason_terminated', $request->status);
        }

        $logs = $query->latest()->paginate(15);

        return view('pages.call_logs.index', compact('logs'));
    }
}