<?php

namespace App\Http\Controllers;

use App\Orders;
use Illuminate\Http\Request;
use DB;

class OrderController extends Controller
{
    public function index()
    {
        $orders = [
            [
                'title' => 'Все заказы',
                'type' => 'value',
                'value' => Orders::count()
            ],
            [
                'title' => 'Самавывоз',
                'type' => 'value',
                'value' => Orders::where('delivery_id', '15')->count()
            ],
            [
                'title' => 'Срочные',
                'type' => 'value',
                'value' => Orders::where('delivery_id', '16')->count()
            ],
            [
                'title' => 'На время',
                'type' => 'value',
                'value' => Orders::where('delivery_id', '14')->count()
            ],
            [
                'title' => 'Самавывоз',
                'type' => 'chart',
                'color' => '#6be6c1',
                'value' => $this->getChart(Orders::where('delivery_id', '15'), 'date')
            ],

        ];
        return response()
            ->json(['orders' => $orders]);
    }


    public function getChart($model, $column)
    {
        $valueFormat = DB::raw("DATE_FORMAT(".$column.", '%d') as value");
        $start = now()->startOfMonth();
        $end = now()->endOfMonth();
        $dates = [];
        $run = $start->copy();
        while($run->lte($end)) {
            $dates = array_add($dates, $run->copy()->format('d'), 0);
            $run->addDay(1);
        }
        $res = $model->groupBy($column)
            ->select(DB::raw('count(*) as total'), $valueFormat)
            ->pluck('total', 'value');
        $all = $res->toArray() + $dates;
        ksort($all);
        return collect(array_values($all))->map(function($item) {
            return ['value' => $item];
        });
    }
}
