@extends('template')

@section('title','marcas')

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
    <h1 class="mt-4 text-center">Marcas</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Marcas</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('marcas.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button></a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Marcas
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Nombre</th>
                        <th>Descripcion</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($marcas as $marca)
                    <tr>
                        <td>{{$marca->caracteristica->nombre}}</td>
                        <td>{{$marca->caracteristica->descripcion}}</td>
                        <td>
                            @if($marca->caracteristica->estado == 1)
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Inactivo</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('marcas.edit',['marca'=>$marca])}}">
                                    <!-- @csrf -->
                                    <button type="submit" title="Editar" class="btn btn-warning"><i class="fa-solid fa-pen-to-square"></i></button>
                                </form>
                                @if($marca->caracteristica->estado == 1)
                                <button type="button" class="btn btn-danger" title="Eliminar"  data-bs-toggle="modal" data-bs-target="#confirmModal-{{$marca->id}}"><i class="fa-solid fa-trash"></i></button>
                                @else
                                <button type="button" class="btn btn-dark" title="Restaurar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$marca->id}}"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal-{{$marca->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de Confirmacion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   {{$marca->caracteristica->estado == 1 ? '¿Esta seguro que desea eliminar la marca?' : '¿Esta seguro que quieres restaurar la marca?'}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{route('marcas.destroy',['marca'=>$marca->id])}}" method="post">
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
@endpush
