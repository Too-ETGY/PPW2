<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TabelController extends Controller
{
    public function index()
    {
        return view('welcome');
    }

    public function create(){}

    public function store(Request $request){}

    public function show(string $id){
        return view('see', ['id' => $id]);
    }

    public function edit(string $id){}

    public function update(Request $request, string $id){}

    public function destroy(string $id){}
}
