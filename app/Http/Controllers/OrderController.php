<?php

namespace App\Http\Controllers;

use App\Orders;
use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index()
    {
        return Orders::all();
    }

    public function show($id)
    {
        return Orders::find($id);
    }

    public function store(Request $request)
    {
        return Orders::create($request->all());
    }

    public function update(Request $request, $id)
    {
        $article = Orders::findOrFail($id);
        $article->update($request->all());

        return $article;
    }

    public function delete(Request $request, $id)
    {
        $article = Orders::findOrFail($id);
        $article->delete();

        return 204;
    }
}
