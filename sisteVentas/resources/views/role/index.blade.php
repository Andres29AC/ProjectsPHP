@extends('template')
@section('title,'roles')
@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
@endpush
@section('content')
@if (session('success'))
<script>
    let message = "{{session('success')}}"
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
        didOpen: (toast) => {
            toast.addEventListener('mouseenter', Swal.stopTimer)
            toast.addEventListener('mouseleave', Swal.resumeTimer)
        }
    })

    Toast.fire({
        icon: 'success',
        title: message
    })
</script>
@endif
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">
        <div style="display: inline-block;">
            <lord-icon src="https://cdn.lordicon.com/gyevrheg.json" trigger="loop-on-hover" stroke="light" 
            style="margin-right: 10px;;display: inline-block;vertical-align: middle;width:70px;height:70px">
            </lord-icon>
        </div>
        Roles
    </h1>
    <!-- dando un espacio -->
    <br>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Roles</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('roles.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo Rol</button></a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Roles
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Rol</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($roles as $item)
                    <tr>
                        <td>
                            {{$item->name}}
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('roles.edit',['role'=>$item])}}" method="get">
                                    <button  type="submit" title="Editar" class="editar btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                                </form>
                                <button type="button" class=" eliminar btn btn-danger"  title="Eliminar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </td>
                    </tr>
                    <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de Confirmacion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   ¿Esta seguro que desea eliminar el rol?
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{route('roles.destroy',['role'=>$item->id])}}" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button type="submit" class="btn btn-danger">Confirmar</button>                                        
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
<style>
    .editar{
        height: 40px;
    }
    .eliminar{
        height: 40px;
    }
</style>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{asset('js/datatables-simple-demo.js')}}"></script>
<script src="https://cdn.lordicon.com/lordicon-1.1.0.js"></script>
@endpush