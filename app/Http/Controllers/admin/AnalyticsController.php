<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Analytics;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Spatie\Analytics\Period;

class AnalyticsController extends Controller {
    private $period;
    private $start_date;
    private $end_data;

    public function __construct() {
        parent::__construct();
        $this->end_data = Carbon::now();
        $this->start_date = Carbon::now();
    }

    public function Page(Request $request) {
        switch ($request->period) {
            case 'week':
                $title = ' | За неделю';
                $this->start_date->subWeek();
                break;
            case 'month':
                $title = ' | За месяц';
                $this->start_date->subMonth();
                break;
            case 'year':
                $title = ' | За год';
                $this->start_date->subYear();
                break;
            case 'at_first':
                $title = ' | С самого начала';
                $this->start_date = Carbon::create('2017', '09', '27');
                break;
            default:
                $title = ' | За неделю';
                $this->start_date->subWeek();
        }

        $this->period = Period::create($this->start_date, $this->end_data);

        $data = (object)[
            'period' => $request->period,
            'title' => 'Аналитика'.$title,
            'total_visitors_and_page_views' => Analytics::fetchTotalVisitorsAndPageViews($this->period),
            'most_visited_pages' => Analytics::fetchMostVisitedPages($this->period),
            'top_browsers' => Analytics::fetchTopBrowsers($this->period, 10),
            'active_users' => Analytics::getAnalyticsService()->data_realtime->get('ga:161302566', 'rt:activeUsers')->rows[0][0],
            'user_devices' => Analytics::performQuery(
                $this->period,
                'ga:users',
                ['dimensions' => 'ga:deviceCategory']
            )->rows,
            'user_countries' => Analytics::performQuery(
                $this->period,
                'ga:users',
                ['dimensions' => 'ga:country']
            )->rows
        ];
        return view('admin.analytics.main', ['page' => $data]);
    }
}