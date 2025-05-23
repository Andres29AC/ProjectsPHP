@extends('template')

@section('title','Crear Proveedores')

@push('css')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<style>
        #box-razon-social{
            display: none;
        }
</style>
@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Proveedores</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{route('proveedores.index')}}">Proveedores</a></li>
        <li class="breadcrumb-item active">Crear Proveedor</li>
    </ol>
    @if ($errors->any())
    <div class="alert alert-danger">
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
    @endif
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
    <form action="{{route('proveedores.store')}}" method="post">
            @csrf <!-- directiva de token de seguridad y para enviar datos -->
            <div class="row g-3">
                <!-- tipo de persona -->
                <div class="col-md-6">
                    <label for="tipo_persona" class="form-label">Tipo de Proveedor:</label>
                    <select class="form-select" name="tipo_persona" id="tipo_persona">
                        <option value="" selected disabled>Selecciona una opcion</option>
                        <option value="natural"{{old('tipo_persona') == 'natural' ? 'selected' : ''}}>Persona Natural</option>
                        <option value="juridica" {{old('tipo_persona') == 'juridica' ? 'selected' : ''}}>Persona Juridica</option>
                    </select>
                    @error('nombre')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <!-- Razon social -->
                <div class="col-mb-12 mb-2" id="box-razon-social">
                    <label id="label-natural" for="razon_social" class="form-control">Nombres y Apellidos</label>
                    <label id="label-juridica" for="razon_social" class="form-control">Nombre de la Empresa</label>
                    <input type="text" value="{{old('razon_social')}}" name="razon_social" id="razon_social" class="form-control">
                    @error('razon_social')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <!-- Descripcion -->
                <div class="col-md-10 mb-2">
                    <label for="direccion" class="form-control">Direccion</label>
                    <input type="text" value="{{old('direccion')}}" name="direccion" id="direccion" class="form-control">
                    @error('direccion')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <!-- Documento -->
                <div class="col-md-6">
                    <label for="documento_id" class="form-label">Tipo de Documento:</label>
                    <select class="form-select" name="documento_id" id="documento_id">
                        <option value="" selected disabled>Selecciona una opcion</option>
                        @foreach($documentos as $item)
                        <option value="{{$item->id}}" {{old('documento_id') == $item->id  ? 'selected' : ''}}>{{$item->tipo_documento}}</option>
                        @endforeach
                    </select>
                    @error('documento_id')
                    <small class="text-danger">{{$message}}</small>
                    @enderror
                </div>
                <div class="col-md-6 mb-2">
                    <label for="numero_documento" class="form-label">Numero de Documento</label>
                    <input type="text" value="{{old('numero_documento')}}" name="numero_documento" id="numero_documento" class="form-control">
                    @error('numero_documento')
                    <small class="text-danger">{{$message}}</small>
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
<script>
    $(document).ready(function(){
        $('#tipo_persona').on('change',function(){
            let selectValue = $(this).val();
            
            if(selectValue == 'natural'){
                $('#label-juridica').hide();
                $('#label-natural').show();
            }else{
                $('#label-natural').hide();
                $('#label-juridica').show();
            }
            $('#box-razon-social').show();
        });
    });
</script>
@endpush
