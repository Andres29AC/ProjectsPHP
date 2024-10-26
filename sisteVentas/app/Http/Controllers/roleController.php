<?php

namespace App\Http\Controllers;

use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class roleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    // 'ver-role',
    // 'crear-role',
    // 'editar-role',
    // 'eliminar-role',
    function __construct()
    {
        $this->middleware('permission:ver-role|crear-role|editar-role|eliminar-role')->only('index');
        $this->middleware('permission:crear-role')->only(['create', 'store']);
        $this->middleware('permission:editar-role')->only(['edit', 'update']);
        $this->middleware('permission:eliminar-role')->only('destroy');
    }
    public function index()
    {
        $roles = Role::all();
        return view('role.index', compact('roles'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //Recuperando todos los permisos
        $permisos = Permission::all();
        return view('role.create', compact('permisos'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles,name',
            'permission' => 'required'
        ]);
        //dd($request->permission);
        try {
            DB::beginTransaction();
            $rol = Role::create(['name' => $request->name]);
            //dd($rol);
            $permissions = Permission::whereIn('id', $request->permission)->pluck('name');
            $rol->syncPermissions($permissions);
            DB::commit();
        } catch (Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
        }
        return redirect()->route('roles.index')->with('success', 'Rol creado correctamente');
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
    public function edit(Role $role)
    {
        $permisos = Permission::all();
        return view('role.edit', compact('role', 'permisos'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
            'permission' => 'required'
        ]);
    
        try {
            DB::beginTransaction();
    
            $role->update(['name' => $request->name]);
    
            $permissions = Permission::whereIn('id', $request->permission)->pluck('name');
    
            $role->syncPermissions($permissions);
    
            DB::commit();
    
        } catch (Exception $e) {
            DB::rollBack();
            //dd($e->getMessage());
        }
    
        return redirect()->route('roles.index')->with('success', 'Rol actualizado correctamente');
    }
    

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        Role::where('id', $id)->delete();
        return redirect()->route('roles.index')->with('success', 'Rol eliminado correctamente');
    }
}
