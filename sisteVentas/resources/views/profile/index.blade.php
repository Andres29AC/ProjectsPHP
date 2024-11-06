@extends('template')

@section('title','Perfil')
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
<div class="container">
    <h1 class="mt-4 text-center">Configurar perfil</h1>
    <div class="container card mt-4">
        <div class="mt-4">
            @if($errors->any())
            @foreach($errors->all() as $item)
            <div class="alert alert-danger   alert-dismissible fade show" role="alert">
                <strong>{{$item}}</strong>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
            @endforeach
            @endif
        </div>
        <form class="card-body" action="{{route('profile.update',['profile' => $user])}}" method="POST">
            @method('PATCH')
            @csrf
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled class="form-control" type="text" value="Nombres">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" name="name" id="name" class="form-control" value="{{old('name',$user->name)}}">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled class="form-control" type="text" value="Email">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="text" name="email" id="email" class="form-control" value="{{old('name',$user->email)}}">
                </div>
            </div>
            <div class="row mb-4">
                <div class="col-sm-4">
                    <div class="input-group">
                        <span class="input-group-text"><i class="fa-solid fa-square-check"></i></span>
                        <input disabled class="form-control" type="text" value="Contraseña">
                    </div>
                </div>
                <div class="col-sm-8">
                    <input type="password" name="password" id="password" class="form-control">
                </div>
            </div>
            <div class="col text-center">
                <input class="btn btn-success" type="submit" value="Guardar cambios">
            </div>
        </form>
    </div>

</div>
@endsection

@push('js')
@endpush
