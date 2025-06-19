<?php

namespace App\Http\Controllers\StarWars;

use App\Models\Query;
use Illuminate\Support\Arr;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Cache;

class StatisticsController extends Controller
{
    public function statistics(): JsonResponse
    {
        $queryCount = Query::count();

        return response()->json([
            'top_five_queries' => Cache::remember(
                key: "top_five_queries",
                ttl: now()->addMinutes(5),
                callback: fn () => Arr::map(DB::table('queries')
                    ->select(['query', DB::raw('count(*) as total')])
                    ->groupBy('query')
                    ->orderBy('total', 'desc')
                    ->limit(5)
                    ->get()
                    ->toArray(), fn($item) => [
                        'query' => $item->query,
                        'total' => $item->total,
                        'percentage' => strval(round($item->total / $queryCount * 100)) . "%"
                    ])
            )
        ]);
    }
}
