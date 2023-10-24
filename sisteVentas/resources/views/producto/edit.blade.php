@extends('template')
@section('title',' Editar Producto')
@push('css')
    <style>
        #descripcion{
            resize: none;
        }
        /* :required{
            box-shadow: 0 0 5px grey;
        } */
    </style>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
@endpush 
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Editar Producto</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{route('productos.index')}}">Producto</a></li>
        <li class="breadcrumb-item active">Editar Producto</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('productos.update',['producto'=>$producto])}}" method="post" enctype="multipart/form-data">
            @method('PATCH')
            @csrf
            <div class="row g-3">
                <!--NOTE: Codigo -->
                <div class="col-md-6 mb-2">
                    <label for="codigo" class="form-label">Codigo</label>
                    <input  type="text" name="codigo" id="codigo" class="form-control" value="{{old('codigo',$producto->codigo)}}">
                    @error('codigo')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--NOTE: Nombre -->
                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Nombre</label>
                    <input type="text" name="nombre" id="nombre" class="form-control" value="{{old('nombre',$producto->nombre)}}">
                    @error('nombre')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--NOTE: Descripcion -->
                <div class="col-md-12 mb-2">
                    <label for="descripcion" class="form-label">Descripcion</label>
                    <textarea  name="descripcion" id="descripcion"  rows="4" class="form-control">{{old('descripcion',$producto->descripcion)}}</textarea>
                    @error('descripcion')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--NOTE: El stock todavia no se colocara ya que se calculara cuando registremos una compra -->
                <!--NOTE: Fecha de vencimiento -->
                <div class="col-md-6 mb-2">
                    <label for="nombre" class="form-label">Fecha de Vencimiento</label>
                    <input  type="date" name="fecha_vencimiento" id="fecha_vencimiento" class="form-control" value="{{old('fecha_vencimiento',$producto->fecha_vencimiento)}}">
                    @error('fecha_vencimiento')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--NOTE: Imagen -->
                <div class="col-md-6 mb-2">
                    <label for="img_path" class="form-label">Imagen</label>
                    <input  type="file" name="img_path" id="img_path" class="form-control" accept="Image/*">
                    @error('img_path')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--NOTE: Marca -->
                <div class="col-md-6 mb-2">
                    <label for="marca_id" class="form-label">Marca</label>
                    <select data-size="5" data-live-search="true" name="marca_id" id="marca_id" class="form-control selectpicker show-tick" title="Seleccionar una marca">
                        @foreach ($marcas as $item)
                        @if($producto->marca_id == $item->id)
                        <option selected value="{{$item->id}}" {{ old('marca_id') == $item->id ? 'selected' : '' }}>{{$item->nombre}}</option>
                        @else
                        <option value="{{$item->id}}" {{ old('marca_id') == $item->id ? 'selected' : '' }}>{{$item->nombre}}</option>
                        @endif     
                        @endforeach
                    </select>
                    @error('marca_id')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--NOTE: Presentacion -->
                <div class="col-md-6 mb-2">
                    <label for="presentacion_id" class="form-label">Presentacion</label>
                    <select data-size="5" data-live-search="true" name="presentacion_id" id="presentacion_id" class="form-control selectpicker show-tick"  title="Seleccionar una presentacion">
                        @foreach ($presentaciones as $item)
                        @if($producto->presentacion_id == $item->id)
                        <option selected value="{{$item->id}}" {{ old('presentacion_id') == $item->id ? 'selected' : '' }}>{{$item->nombre}}</option>
                        @else
                        <option value="{{$item->id}}" {{ old('presentacion_id') == $item->id ? 'selected' : '' }}>{{$item->nombre}}</option>
                        @endif
                        @endforeach
                    </select>
                    @error('presentacion_id')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <!--NOTE: Categoria -->
                <div class="col-md-6 mb-2">
                    <select data-size="5" data-live-search="true" name="categorias[]" id="categorias" class="form-control selectpicker show-tick"  title="Seleccionar una categoria" multiple>
                        @foreach ($categorias as $item)
                        @if(in_array($item->id ,$producto->categoria->pluck('id')->toArray()))
                        <option selected value="{{$item->id}}" {{ (in_array($item->id , old('categorias',[]))) ? 'selected' : '' }}>{{$item->nombre}}</option>
                        @else
                        <option value="{{$item->id}}" {{ (in_array($item->id , old('categorias',[]))) ? 'selected' : '' }}>{{$item->nombre}}</option>
                        @endif
                        @endforeach
                    </select>
                    @error('categorias')
                    <small class="text-danger">{{'*'.$message}}</small>
                    @enderror
                </div>
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
@endpush
