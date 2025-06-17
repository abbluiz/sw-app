<?php

namespace App\Http\Controllers\StarWars;

use App\Models\Query;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;

class StatisticsController extends Controller
{
    public function statistics(): JsonResponse
    {
        $queryCount = Query::count();

        return response()->json([
            'top_five_queries' => Arr::map(DB::table('queries')
                    ->select(['query', DB::raw('count(*) as total')])
                    ->groupBy('query')
                    ->orderBy('total', 'desc')
                    ->limit(5)
                    ->get()
                    ->toArray(), function($item) use ($queryCount) {
                        return [
                            'query' => $item->query,
                            'total' => $item->total,
                            'percentage' => strval(round($item->total / $queryCount * 100)) . "%"
                        ];
                    })
        ]);
    }
}
