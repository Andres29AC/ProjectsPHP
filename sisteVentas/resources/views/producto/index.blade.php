@extends('template')
@section('title','Productos')
@push('css')
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<link href="https://cdn.jsdelivr.net/npm/simple-datatables@latest/dist/style.css" rel="stylesheet" type="text/css">
<style>
    .category {
        display: inline-block;
        padding: 5px 10px;
        border-radius: 20px;
        background-color: #0d6efd;
        color: #fff;
        font-weight: bold;
        font-size: 14px;
        transition: background-color 0.3s, color 0.3s;
        cursor: pointer;
    }

    .category:hover {
        background-color: #3c7c50;
        color: #0d6efd;
    }

    .product-image {
        
        transition: transform 0.9s; 
        transition: box-shadow 0.3s;
    }

    .product-image:hover {
        transform: rotateY(180deg); 
        /* transform: rotateY(360deg) rotateX(360deg); */
        box-shadow: 0 0 10px rgba(0, 0, 0, 1.2);
    }

    .close {
        margin: 0 auto;
        padding-top: 3px;
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
    <h1 class="mt-4 text-center">Productos</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item active">Productos</li>
    </ol>
    <div class="mb-4">
        <a href="{{route('productos.create')}}"><button type="button" class="btn btn-primary">Añadir nuevo registro</button></a>
    </div>
    <div class="card mb-4">
        <div class="card-header">
            <i class="fas fa-table me-1"></i>
            Tabla Productos
        </div>
        <div class="card-body">
            <table id="datatablesSimple" class="table table-striped">
                <thead>
                    <tr>
                        <th>Codigo</th>
                        <th>Nombre</th>
                        <th>Marca</th>
                        <th>Presentacion</th>
                        <th>Categoria</th>
                        <th>Estado</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productos as $item)
                    <tr>
                        <td>
                            {{$item->codigo}}
                        </td>
                        <td>
                            {{$item->nombre}}
                        </td>
                        <td>
                            {{$item->marca->caracteristica->nombre}}
                        </td>
                        <td>
                            {{$item->presentacion->caracteristica->nombre}}
                        </td>
                        <td>
                            @foreach ($item->categoria as $categoria)
                            <div class="container">
                                <div class="row">
                                    <span class="category m-1 rounded-pill p-1 text-white text-center">{{$categoria->caracteristica->nombre}}</span>
                                </div>
                            </div>
                            @endforeach
                        </td>
                        <td>
                            @if($item->estado == 1)
                            <span class="badge bg-success">Activo</span>
                            @else
                            <span class="badge bg-danger">Eliminado</span>
                            @endif
                        </td>
                        <td>
                            <div class="btn-group" role="group" aria-label="Basic mixed styles example">
                                <form action="{{route('productos.edit',['producto' =>$item])}}">
                                    <button type="submit" class="btn btn-warning" title="Editar"><i class="fa-solid fa-pen-to-square"></i></button>
                                </form>
                                <button type="button" class="btn btn-success" title="Ver" data-bs-toggle="modal" data-bs-target="#verModal-{{$item->id}}"><i class="fa-solid fa-eye"></i></button>
                                @if($item->estado == 1)
                                <button type="button" class="btn btn-danger" title="Eliminar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}"><i class="fa-solid fa-trash"></i></button>
                                @else
                                <button type="button" class="btn btn-dark" title="Restaurar" data-bs-toggle="modal" data-bs-target="#confirmModal-{{$item->id}}"><i class="fa-solid fa-trash-arrow-up"></i></button>
                                @endif
                            </div>
                        </td>
                    </tr>
                    <!-- Modal -->
                    <div class="modal fade" id="verModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog modal-dialog-scrollable">
                            <div class="modal-content">
                                <div class="modal-header" style="margin: 0 auto;">
                                    <h5 class="modal-title"  id="exampleModalLabel">Informacion Adicional</h5>
                                </div>
                                <div class="modal-body">
                                    <div class="row mb-3">
                                        <label for=""><span class="fw-bolder">Descripcion:</span> {{$item->descripcion}}</label>
                                    </div>
                                    <div class="row mb-3">
                                        <label for=""><span class="fw-bolder">Fecha de Vencimiento:</span>{{$item->fecha_vencimiento =='' ? 'No tiene' : $item->fecha_vencimiento}}</label>
                                    </div>
                                    <div class="row mb-3">
                                        <label for=""><span class="fw-bolder">Stock:</span>{{$item->stock}}</label>
                                    </div>
                                    <div class="row">
                                        <label class="fw-bolder">Imagen: </label>
                                        <div style="text-align: center;">
                                            @if($item->img_path != 'default.png')
                                            <!-- <img class="product-image" src="{{asset('storage/productos/'.$item->img_path)}}" alt="{{$item->nombre}}" width="50px" height="50px"> -->
                                            <img src="{{Storage::url('public/productos/'.$item->img_path)}}" alt="{{$item->nombre}}" class="product-image" width="220px" height="220px">
                                            @else
                                            <img src="" alt="{{$item->nombre}}">
                                            @endif
                                        </div>
                                    </div>
                                </div>
                                <div class="close modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <!-- Modal -->
                    <div class="modal fade" id="confirmModal-{{$item->id}}" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h1 class="modal-title fs-5" id="exampleModalLabel">Mensaje de Confirmacion</h1>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                   {{$item->estado == 1 ? '¿Esta seguro que desea eliminar el producto?' : '¿Esta seguro que quieres restaurar el producto?'}}
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                                    <form action="{{route('productos.destroy',['producto'=>$item->id])}}" method="post">
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