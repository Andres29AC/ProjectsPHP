@extends('template')

@section('title','proveedores')

@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<style>
     .supplier {
        /* colocandolo a la derecha */
        float: left;
        width: 80px;
        height: 80px;
    }

    .supplier:hover {
        background-color: whitesmoke;
    }
</style>
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
        Proveedores
        <lord-icon class="supplier" src="https://cdn.lordicon.com/lxrsqlrx.json" trigger="loop-on-hover" >
        </lord-icon>
    </h1>
    <!-- dando un espacio -->
    <br>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Proveedores</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('proveedores.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button></a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Proveedores
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Direccion</th>
                        <th>Tipo de Documento</th>
                        <th>Numero de Documento</th>
                        <th>Tipo de Persona</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($proveedores as $item)
                    <tr>
                        <td>
                            {{$item->persona->razon_social}}
                        </td>
                        <td>
                            {{$item->persona->direccion}}
                        </td>
                        <td>
                            {{$item->persona->documento->tipo_documento}}
                        </td>
                        <td>
                            {{$item->persona->numero_documento}}
                        </td>
                        <td>
                            {{$item->persona->tipo_persona}}
                        </td>
                        <td>
                            @if ($item->persona->estado == 1)
                            <span class="fw-bolder p-1 rounded bg-success text-white">Activo</span>
                            @else
                            <span class="fw-bolder p-1 rounded bg-danger text-white">Eliminado</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('proveedores.edit',['proveedore'=>$item])}}" method="get">
                                    <button type="submit" title="Editar" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                                </form>
                                @if($item->persona->estado == 1)
                                <button type="button" class="btn btn-danger"  title="Eliminar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}"><i class="fa-solid fa-trash"></i></button>
                                @else
                                <button type="button" class="btn btn-dark" title="Restaurar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}" ><i class="fa-solid fa-trash-arrow-up"></i></button>
                                @endif
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
                                   {{$item->persona->estado == 1 ? '¿Esta seguro que desea eliminar el proveedor?' : '¿Esta seguro que quieres restaurar el proveedor?'}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{route('proveedores.destroy',['proveedore'=>$item->persona->id])}}" method="post">
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
@endsection

@push('js')
<script src="https://cdn.jsdelivr.net/npm/simple-datatables@latest" type="text/javascript"></script>
<script src="{{asset('js/datatables-simple-demo.js')}}"></script>
<script src="https://cdn.lordicon.com/lordicon-1.1.0.js"></script>
@endpush
