<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePersonaRequest;
use App\Http\Requests\StoreProveedorRequest;
use App\Http\Requests\UpdateProveedorRequest;
use App\Models\Documento;
use App\Models\Persona;
use App\Models\Proveedore;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProveedorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $proveedores = Proveedore::with('persona.documento')->get();
        //dd($proveedores);
        return view('proveedore.index', compact('proveedores'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $documentos = Documento::all();
        return view('proveedore.create', compact('documentos'));
    }

    /**
     * Store a newly created resource in storage.
     */
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
            } elseif ($tipoDocumento === 'Carnet de Extranjeria' && strlen($numeroDocumento) !== 20) {
                throw new \Exception('Carnet de Extranjeria debe tener 20 dígitos.');
            }
            $persona = Persona::create($personaData);
            $persona->proveedore()->create([
                'persona_id' => $persona->id
            ]);
            DB::commit();
        } catch (Exception $e) {
            //dd($e);
            DB::rollBack();
            return redirect()->back()->withInput()->withErrors([$e->getMessage()]);
        }

        return redirect()->route('proveedores.index')->with('success', 'Proveedor registrado');
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
    public function edit(Proveedore $proveedore)
    {
        $proveedore->load('persona.documento');
        $documentos = Documento::all();
        return view('proveedore.edit',compact('proveedore','documentos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProveedorRequest $request, Proveedore $proveedore)
    {
        try {
            DB::beginTransaction();

            $persona = $proveedore->persona;
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

        return redirect()->route('proveedores.index')->with('success', 'Proveedor actualizado con éxito');
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
            $message = 'Proveedor eliminado con exito';
        }else{
            Persona::where('id',$persona->id)->update([
                'estado' => ' 1'
            ]);
            $message = 'Proveedor restaurado con exito';
        }
        
        return redirect()->route('proveedores.index')->with('success',$message);
    }
}
