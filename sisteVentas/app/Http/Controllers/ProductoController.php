<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreProductoRequest;
use App\Http\Requests\UpdateeProductoRequest;
use App\Models\Marca;
use App\Models\Presentacione;
use App\Models\Categoria;
use App\Models\Producto;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class ProductoController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // 'ver-producto',
    // 'crear-producto',
    // 'editar-producto',
    // 'eliminar-producto',
    function __construct()
    {
         $this->middleware('permission:ver-producto|crear-producto|editar-producto|eliminar-producto')->only('index');
         $this->middleware('permission:crear-producto', ['only' => ['create','store']]);
         $this->middleware('permission:editar-producto', ['only' => ['edit','update']]);
         $this->middleware('permission:eliminar-producto', ['only' => ['destroy']]);
    }
    public function index()
    {
        $productos = Producto::with(['categoria.caracteristica','marca.caracteristica','presentacion.caracteristica'])->latest()->get();
        return view('producto.index',compact('productos'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $marcas = Marca::join('caracteristicas as c','marcas.caracteristica_id','=','c.id')
        ->select('marcas.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        $presentaciones = Presentacione::join('caracteristicas as c','presentaciones.caracteristica_id','=','c.id')
        ->select('presentaciones.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        $categorias = Categoria::join('caracteristicas as c','categorias.caracteristica_id','=','c.id')
        ->select('categorias.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        return view('producto.create',compact('marcas','presentaciones','categorias'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProductoRequest $request)
    {
        //dd($request);
        try{
            DB::beginTransaction();
            //NOTE llenando tabla producto
            $producto = new Producto();
            if($request->hasFile('img_path')){
                $name = $producto->handleUploadImage($request->file('img_path'));
            }else{
                $name = null;
            }
            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'img_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacion_id' => $request->presentacion_id
            ]);
            $producto->save();
            //NOTE - llenando tabla categria_producto
            $categorias = $request->get('categorias');
            $producto->categoria()->attach($categorias);
            DB::commit();

        }catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('productos.index')->with('success','Producto registrado correctamente');
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
    public function edit(Producto $producto)
    {
        $marcas = Marca::join('caracteristicas as c','marcas.caracteristica_id','=','c.id')
        ->select('marcas.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        $presentaciones = Presentacione::join('caracteristicas as c','presentaciones.caracteristica_id','=','c.id')
        ->select('presentaciones.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        $categorias = Categoria::join('caracteristicas as c','categorias.caracteristica_id','=','c.id')
        ->select('categorias.id as id','c.nombre as nombre')
        ->where('c.estado',1)
        ->get();
        return view('producto.edit',compact('producto','marcas','presentaciones','categorias'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateeProductoRequest $request, Producto $producto)
    {
        try{
            DB::beginTransaction();
            if($request->hasFile('img_path')){
                $name = $producto->handleUploadImage($request->file('img_path'));
                if(Storage::disk('public')->exists('productos/'.$producto->img_path)){
                    Storage::disk('public')->delete('productos/'.$producto->img_path);                        
                }
            }else{
                $name = $producto->img_path;
            }
            $producto->fill([
                'codigo' => $request->codigo,
                'nombre' => $request->nombre,
                'descripcion' => $request->descripcion,
                'fecha_vencimiento' => $request->fecha_vencimiento,
                'img_path' => $name,
                'marca_id' => $request->marca_id,
                'presentacion_id' => $request->presentacion_id
            ]);
            $producto->save();
            //NOTE - llenando tabla categria_producto
            $categorias = $request->get('categorias');
            $producto->categoria()->sync($categorias);
            DB::commit();
        } catch(Exception $e){
            DB::rollBack();
        }
        return redirect()->route('productos.index')->with('success','Producto actualizado correctamente');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $producto = Producto::find($id);
        if($producto->estado ==  1){
            Producto::where('id',$producto->id)->update([
                'estado' => '0'
            ]);
            $message = 'Producto eliminada con exito';
        }else{
            Producto::where('id',$producto->id)->update([
                'estado' => ' 1'
            ]);
            $message = 'Producto restaurado con exito';
        }
        
        return redirect()->route('productos.index')->with('success',$message);
    }
}
