<?php

namespace serranatural\Http\Controllers;

use Illuminate\Support\Facades\Request;
use Illuminate\Support\Facades\DB;

use serranatural\Http\Requests;
use serranatural\Http\Controllers\Controller;

use serranatural\Models\ReceitaPrato;

class ReceitasController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return Response
     */
    public function addIngrediente()
    {

        ReceitaPrato::create(Request::all());

        return back();

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return Response
     */
    public function excluiIngrediente()
    {
        $id = Request::route('id');

        ReceitaPrato::find($id)->delete();

        return back();

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  Request  $request
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  Request  $request
     * @param  int  $id
     * @return Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
}
