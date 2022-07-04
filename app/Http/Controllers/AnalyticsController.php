<?php

namespace App\Http\Controllers;

use Analytics;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Spatie\Analytics\Period;

class AnalyticsController extends Controller
{

    public function __construct()
    {
        /*
         * Middleware definition
         * It's used to define that all the methods in this controller the user must be authenticated and have an administrator role assigned.
         */
        $this->middleware('auth');
        $this->middleware('role:role_admin;role_it');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $totalUsers = 0;
        $totalSessions = 0;
        $totalPages = 0;
        $totalBounces = 0;
        $processedArray = array();
        $processedPages = array();

        $totalVisitors = $this->fetchTotalVisitorsPageViewsAndBounces(Period::days(30));

        $totalVisitors->each(function ($item) use (&$totalUsers, &$totalPages, &$processedArray, &$totalBounces, &$totalSessions) {

            $totalUsers += $item['visitors'];
            $totalPages += $item['pageViews'];
            $totalBounces += $item['bounces'];
            $totalSessions += $item['sessions'];

            array_push($processedArray, [
                'day' => $item['date']->format('Y-m-d H:i:s'),
                'uniqueUsers' => $item['visitors'],
                'sessions' => $item['sessions'],
                'pageViews' => $item['pageViews'],
                'bounces' => $item['bounces']
            ]);

        });

        /**
         *  Top pages
         */
        $pages = Analytics::fetchMostVisitedPages(Period::days(30), 20);

        // Excluding TEST environment
        $pages->each(function ($item) use (&$processedPages){

            if(!str_contains($item['pageTitle'], 'TEST')){

                array_push($processedPages, [
                    'url' => $item['url'],
                    'pageViews' => $item['pageViews']
                ]);

            }

        });

        /**
         * Browsers
         */
        $browsers = Analytics::fetchTopBrowsers(Period::days(30))->sortBy('sessions')->reverse();

        /**
         * Countries
         */

        $countries_array = Analytics::performQuery(Period::days(30),'ga:users',['dimensions'=>'ga:countryIsoCode,ga:country','sort'=>'-ga:users'])->rows;

        if(is_array($countries_array)){
            $countries = array_slice($countries_array,0,20);
        } else {
            $countries = array();
        }

        $jsonArray = \GuzzleHttp\json_encode($processedArray);

        return view('back.analytics.dashboard', compact('jsonArray', 'totalUsers', 'totalPages', 'totalBounces', 'countries', 'totalSessions', 'browsers', 'processedPages'));

    }

    /**
     * @param Period $period
     * @return Collection
     */
    private function fetchTotalVisitorsPageViewsAndBounces(Period $period) : Collection
    {

        $response = Analytics::performQuery(
            $period,
            'ga:users,ga:sessions,ga:pageviews,ga:bounces',
            ['dimensions' => 'ga:date']
        );

        return collect($response['rows'] ?? [])->map(function (array $dateRow) {
            return [
                'date' => Carbon::createFromFormat('Ymd', $dateRow[0]),
                'visitors' => (int) $dateRow[1],
                'sessions' => (int) $dateRow[2],
                'pageViews' => (int) $dateRow[3],
                'bounces' => (int) $dateRow[4],
            ];
        });

    }

}
