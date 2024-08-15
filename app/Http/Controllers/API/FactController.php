<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Fact;
use Illuminate\Http\Request;

class FactController extends Controller
{

    public function index(Request $request)
    {
        $locale = (app()->getLocale()) ? app()->getLocale() : 'da';

        $facts = Fact::where('status', 'published')
            ->orderBy('created_at', 'desc')
            ->paginate(10);


        return response()->json([
            'status' => true,
            'message' => 'facts retrieved successfully',
            'facts' => $facts
        ], 200);
    }


    public function show(Fact $fact)
    {
        return response()->json([
            'status' => true,
            'message' => 'Fact found successfully',
            'data' => $fact
        ], 200);
    }
}
