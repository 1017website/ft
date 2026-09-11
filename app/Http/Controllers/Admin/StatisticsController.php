<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DailyVisitor;
use App\Models\QuotationRequest;
use Illuminate\Http\Request;

class StatisticsController extends Controller
{
    public function __invoke(Request $request)
    {
        $days = in_array((int) $request->query('days', 30), [7, 30, 90]) ? (int) $request->query('days', 30) : 30;
        $start = now('Asia/Jakarta')->startOfDay()->subDays($days - 1);
        $query = DailyVisitor::where('day', '>=', $start->toDateString());
        $series = (clone $query)->selectRaw('day, SUM(views) as views, COUNT(*) as visitors')->groupBy('day')->orderBy('day')->get()->keyBy('day');
        $timeline = collect(range(0, $days - 1))->map(function ($offset) use ($start, $series) {
            $date = $start->copy()->addDays($offset);
            $row = $series->get($date->toDateString());

            return ['date' => $date->format('d M'), 'views' => (int) ($row?->views ?? 0), 'visitors' => (int) ($row?->visitors ?? 0)];
        });

        return view('admin.statistics', [
            'days' => $days, 'timeline' => $timeline, 'views' => $timeline->sum('views'), 'visitors' => $timeline->sum('visitors'),
            'leads' => QuotationRequest::where('created_at', '>=', $start->copy()->utc())->count(),
            'sources' => (clone $query)->selectRaw('source, SUM(views) as total')->groupBy('source')->orderByDesc('total')->limit(10)->get(),
            'devices' => (clone $query)->selectRaw('device, SUM(views) as total')->groupBy('device')->orderByDesc('total')->get(),
        ]);
    }
}
