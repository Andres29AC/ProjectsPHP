<?php

namespace App\Http\Controllers;
use App\Models\Marca;
use App\Http\Requests\StoreMarcaRequest;
use App\Http\Requests\UpdateMarcaRequest;
use App\Models\Caracteristica;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Exception;
class MarcaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // 'ver-marca',
    // 'crear-marca',
    // 'editar-marca',
    // 'eliminar-marca',
    function __construct()
    {
         $this->middleware('permission:ver-marca|crear-marca|editar-marca|eliminar-marca')->only('index');
         $this->middleware('permission:crear-marca', ['only' => ['create','store']]);
         $this->middleware('permission:editar-marca', ['only' => ['edit','update']]);
         $this->middleware('permission:eliminar-marca', ['only' => ['destroy']]);
    }
    public function index()
    {
        $marcas = Marca::with('caracteristica')->latest()->get();
        //dd($categorias);
        return view('marca.index',['marcas' => $marcas]);
        //return view('marca.index');
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('marca.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreMarcaRequest $request)
    {
        //dd($request);
        try{
            DB::beginTransaction();
            $caracteristica = Caracteristica::create($request->validated());
            $caracteristica->marca()->create([
                'caracteristica_id' => $caracteristica->id,
            ]);
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('marcas.index')->with('success','Marca creada con exito');
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
    public function edit(Marca $marca)
    {
        return view('marca.edit',['marca' => $marca]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateMarcaRequest $request, Marca $marca)
    {
        Caracteristica::where('id',$marca->caracteristica->id)->update($request->validated());
        return redirect()->route('marcas.index')->with('success','Marca actualizada con exito');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //dd($id);
        $message = '';
        $marca = Marca::find($id);
        if($marca->caracteristica->estado ==  1){
            Caracteristica::where('id',$marca->caracteristica->id)->update([
                'estado' => '0'
            ]);
            $message = 'Marca eliminada con exito';
        }else{
            Caracteristica::where('id',$marca->caracteristica->id)->update([
                'estado' => ' 1'
            ]);
            $message = 'Marca restaurada con exito';
        }
        
        return redirect()->route('marcas.index')->with('success',$message);
    }
}
