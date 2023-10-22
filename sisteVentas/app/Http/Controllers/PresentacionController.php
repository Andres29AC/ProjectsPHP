<?php

namespace App\Http\Controllers;
use App\Models\Presentacione;
use App\Http\Requests\StorePresentacionRequest;
use App\Http\Requests\UpdatePresentacionRequest;
use App\Models\Caracteristica;
use Illuminate\Support\Facades\DB;
use Exception;

use Illuminate\Http\Request;

class PresentacionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $presentaciones = Presentacione::with('caracteristica')->latest()->get();
        //dd($categorias);
        return view('presentacione.index',['presentaciones' => $presentaciones]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('presentacione.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePresentacionRequest $request)
    {
        //dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->presentacione()->create([
                'caracteristica_id' => $caracteristica->id,
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('presentaciones.index')->with('success','Presentacion creada con exito');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Presentacione $presentacione)
    {
        return view('presentacione.edit',['presentacione' => $presentacione]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdatePresentacionRequest $request, Presentacione $presentacione)
    {
        Caracteristica::where('id',$presentacione->caracteristica->id)->update($request->validated());
        return redirect()->route('presentaciones.index')->with('success','Presentacion actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $presentacione = Presentacione::find($id);
        if($presentacione->caracteristica->estado ==  1){
            Caracteristica::where('id',$presentacione->caracteristica->id)->update([
                'estado' => '0'
            ]);
            $message = 'Marca eliminada con exito';
        }else{
            Caracteristica::where('id',$presentacione->caracteristica->id)->update([
                'estado' => ' 1'
            ]);
            $message = 'Marca restaurada con exito';
        }
        
        return redirect()->route('marcas.index')->with('success',$message);
    }
}
