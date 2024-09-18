<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreCompraRequest;
use App\Models\Compra;
use App\Models\Comprobante;
use App\Models\Proveedore;
use App\Models\Producto;
use Carbon\Carbon;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use PhpParser\Node\Stmt\TryCatch;

class CompraController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $compras = Compra::with('comprobante', 'proveedore.persona')
        ->where('estado', 1)
        ->latest()
        ->get();
        //SECTION - Para ver los datos que se envían desde el formulario
        //dd($compras);
        return view('compra.index',compact('compras'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $proveedores = Proveedore::whereHas('persona', function ($query) {
            $query->where('estado', 1);
        })->get();
        $comprobantes = Comprobante::all();
        $productos = Producto::where('estado', 1)->get();
        return view('compra.create', compact('proveedores', 'comprobantes', 'productos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreCompraRequest $request)
    {
        //dd($request->validated());
        //SECTION -  Para ver los datos que se envían desde el formulario
        //dd($request);
        try{
            DB::beginTransaction();
            $compra = Compra::create($request->validated());
            $arrayProducto_id = $request->get('arrayidproducto');
            $arrayCantidad = $request->get('arraycantidad');
            $arrayPrecioCompra = $request->get('arraypreciocompra');
            $arrayPrecioVenta = $request->get('arrayprecioventa');
            $szearray = count($arrayProducto_id);
            $cont = 0;
            while($cont < $szearray){
                $compra->productos()->syncWithoutDetaching([
                    $arrayProducto_id[$cont] => [
                        'cantidad' => $arrayCantidad[$cont],
                        'precio_compra' => $arrayPrecioCompra[$cont],
                        'precio_venta' => $arrayPrecioVenta[$cont],
                    ]
                ]);
                //Update stock 
                $producto = Producto::find($arrayProducto_id[$cont]);
                $stockActual = $producto->stock;
                $stockNuevo = intval($arrayCantidad [$cont]);
                DB::table('productos')
                    ->where('id', $producto->id)
                    ->update(['stock' => $stockActual + $stockNuevo]);
                $cont++;
            }
            DB::commit();
        }catch(Exception $e){
            DB::rollBack();
            //dd($e->getMessage());
        }
        return redirect()->route('compras.index')->with('success', 'Compra registrada correctamente');
    }

    /**
     * Display the specified resource.
     */
    public function show(Compra $compra)
    {
        //dd($compra->productos);
        return view('compra.show', compact('compra'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
