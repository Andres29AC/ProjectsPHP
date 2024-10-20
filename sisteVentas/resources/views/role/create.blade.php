@extends('template')

@section('title','Crear Rol')

@push('css')

@endpush

@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Rol</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{route('roles.index')}}">Roles</a></li>
        <li class="breadcrumb-item active">Crear Rol</li>
    </ol>
    <div class="container w-100 border border-3 border-primary rounded p-4 mt-3">
        <form action="{{route('roles.store')}}" method="post">
            @csrf <!-- directiva de token de seguridad y para enviar datos -->
            <div class="row g-3">
                <!-- Nombre de Rol -->
                <div class="row mb-4 mt-4">
                    <label for="nombre" class="col-sm-2 col-form-label">Nombre de Rol:</label>
                    <div class="col-sm-4">
                        <input type="text" class="form-control" id="name" name="name" value="{{old('name')}}">
                    </div>
                    <div class="col-sm-6">
                        @error('name')
                        <small class="text-danger">{{'*'.$message}}</small>
                        @enderror
                    </div>
                </div>
                <div class="col-12 mb-4">
                    <label for="" class="form-control">Permisos para el Rol</label>
                    @foreach ($permisos as $item)
                    <div class="form-check mb-2">
                        <input class="form-check-input" name="permission[]" type="checkbox" id="{{$item->id}}" value="{{$item->id}}">
                        <label for="{{$item->id}}" class="form-check-label">{{$item->name}}</label>
                    </div>
                    @endforeach
                </div>
                @error('permission')
                <small class="text-danger">{{'*'.$message}}</small>
                @enderror
                <div class="col-12 text-center">
                    <button type="submit" class="btn btn-primary">Guardar</button>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection

@push('js')
@endpush