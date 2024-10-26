<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\UpdateClienteRequest;
use App\Models\Cliente;
use App\Models\Documento;
use App\Models\Persona;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ClienteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // 'ver-cliente',
    // 'crear-cliente',
    // 'editar-cliente',
    // 'eliminar-cliente',
    function __construct()
    {
        $this->middleware('permission:ver-cliente|crear-cliente|editar-cliente|eliminar-cliente', ['only' => ['index']]);
        $this->middleware('permission:crear-cliente', ['only' => ['create', 'store']]);
        $this->middleware('permission:editar-cliente', ['only' => ['edit', 'update']]);
        $this->middleware('permission:eliminar-cliente', ['only' => ['destroy']]);
    }
    public function index()
    {
        $clientes = Cliente::with('persona.documento')->get();
        //dd($clientes);
        return view('clientes.index', compact('clientes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('clientes.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    // public function store(StorePersonaRequest $request)
    // {
    //     try {
    //         DB::beginTransaction();
    //         $persona = Persona::create($request->all());
    //         $persona->cliente()->create([
    //             'persona_id' => $persona->id
    //         ]);
    //         DB::commit();
    //     } catch (Exception $ex) {
    //         DB::rollBack();
    //     }
    //     return redirect()->route('clientes.index')->with('success', 'Cliente creado con exito');
    // }
    public function store(StorePersonaRequest $request)
    {
        try {
            DB::beginTransaction();
            $personaData = $request->validated();

            $tipoDocumento = Documento::find($personaData['documento_id'])->tipo_documento;
            $numeroDocumento = $personaData['numero_documento'];

            // Realiza la validación del número de dígitos según el tipo de documento
            if ($tipoDocumento === 'DNI' && strlen($numeroDocumento) !== 8) {
                throw new \Exception('El DNI debe tener 8 dígitos.');
            } elseif ($tipoDocumento === 'RUC' && strlen($numeroDocumento) !== 11) {
                throw new \Exception('El RUC debe tener 11 dígitos.');
            } elseif ($tipoDocumento === 'Pasaporte' && strlen($numeroDocumento) !== 9) {
                throw new \Exception('Pasaporte debe tener 9 dígitos.');
            }elseif ($tipoDocumento === 'Carnet de Extranjeria' && strlen($numeroDocumento) !== 20) {
                throw new \Exception('Carnet de Extranjeria debe tener 20 dígitos.');
            }

            $persona = Persona::create($personaData);
            $persona->cliente()->create([
                'persona_id' => $persona->id
            ]);

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            //return redirect()->back()->with('error', $ex->getMessage());
            return redirect()->back()->withInput()->withErrors([$ex->getMessage()]);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente creado con éxito');
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
    public function edit(Cliente $cliente)
    {
        $cliente->load('persona.documento');
        $documentos = Documento::all();
        return view('clientes.edit', compact('cliente', 'documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    // public function update(UpdateClienteRequest $request, Cliente $cliente)
    // {
    //     try{
    //         DB::beginTransaction();
    //         Persona::where('id',$cliente->persona->id)
    //         ->update($request->validated());
    //         DB::commit();
    //     }catch(Exception $ex){
    //         DB::rollBack();
    //     }
    //     return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con exito');
    // }
    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateClienteRequest $request, Cliente $cliente)
    {
        try {
            DB::beginTransaction();

            $persona = $cliente->persona;
            $persona->update($request->validated());

            $tipoDocumento = $persona->documento->tipo_documento;
            $numeroDocumento = $persona->numero_documento;

            // Realiza la validación del número de dígitos según el tipo de documento
            if ($tipoDocumento === 'DNI' && strlen($numeroDocumento) !== 8) {
                throw new \Exception('El DNI debe tener 8 dígitos.');
            } elseif ($tipoDocumento === 'RUC' && strlen($numeroDocumento) !== 11) {
                throw new \Exception('El RUC debe tener 11 dígitos.');
            } elseif ($tipoDocumento === 'Pasaporte' && strlen($numeroDocumento) !== 9) {
                throw new \Exception('Pasaporte debe tener 9 dígitos.');
            }elseif ($tipoDocumento === 'Carnet de Extranjeria' && strlen($numeroDocumento) !== 20) {
                throw new \Exception('Carnet de Extranjeria debe tener 20 dígitos.');
            }

            DB::commit();
        } catch (Exception $ex) {
            DB::rollBack();
            //return redirect()->back()->with('error', $ex->getMessage());
            return redirect()->back()->withInput()->withErrors([$ex->getMessage()]);
        }

        return redirect()->route('clientes.index')->with('success', 'Cliente actualizado con éxito');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $message = '';
        $persona = Persona::find($id);
        if($persona->estado ==  1){
            Persona::where('id',$persona->id)->update([
                'estado' => '0'
            ]);
            $message = 'Cliente eliminado con exito';
        }else{
            Persona::where('id',$persona->id)->update([
                'estado' => ' 1'
            ]);
            $message = 'Cliente restaurado con exito';
        }
        
        return redirect()->route('clientes.index')->with('success',$message);
    }
}
