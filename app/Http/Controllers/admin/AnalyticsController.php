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
    }

    public function Page(Request $request) {
        switch ($request->period) {
            case 'week':
                $this->start_date = Carbon::create($this->end_data->year, $this->end_data->month, $this->end_data->day-7);
                break;
            case 'month':
                $this->start_date = Carbon::create($this->end_data->year, $this->end_data->month-1, $this->end_data->day);
                break;
            case 'year':
                $this->start_date = Carbon::create($this->end_data->year-1, $this->end_data->month, $this->end_data->day);
                break;
            case 'at_first':
                $this->start_date = Carbon::create('2017', '09', '27');
                break;
            default:
                $this->start_date = Carbon::create($this->end_data->year, $this->end_data->month, $this->end_data->day-7);
        }

        $this->period = Period::create($this->start_date, $this->end_data);

        $data = (object)[
            'title' => 'Аналитика',
            //только активные дни (заголовок страницы, количество посетителей, всего просмотрели страницу)
            'visitors_and_page_views' => Analytics::fetchVisitorsAndPageViews($this->period),
            //все дни (количество посетителей, всего просмотрело страниц)
            'total_visitors_and_page_views' => Analytics::fetchTotalVisitorsAndPageViews($this->period),
            //последние 20 посещенных страницы (url, title, количество просмотров)
            'most_visited_pages' => Analytics::fetchMostVisitedPages($this->period, 20),
            'top_browsers' => Analytics::fetchTopBrowsers($this->period, 10),
            'active_users' => Analytics::getAnalyticsService()->data_realtime->get('ga:161302566', 'rt:activeUsers')->rows[0][0]
        ];
        return view('admin.analytics.main', ['page' => $data]);
    }
}