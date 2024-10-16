@extends('template')
@section('title','Realizar Venta')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Realizar Venta</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{route('ventas.index')}}">Ventas</a></li>
        <li class="breadcrumb-item active">Realizar Venta</li>
    </ol>
</div>
<form action="{{route('ventas.store')}}" method="post">
    @csrf
    <div class="container mt-4">
        <div class="row gy-4">
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la venta
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row">
                        <!--Producto-->
                        <div class="col-md-12 mb-2">
                            <select name="producto_id" id="producto_id" class="form-control selectpicker show-tick" data-live-search="true" title="Busque un producto aqui" data-size="3">
                                @foreach ($productos as $item)
                                <option value="{{$item->id}}-{{$item->stock}}-{{$item->precio_venta}}">{{$item->codigo.' '.$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--Stock-->
                        <div class="d-flex justify-content-end mb-4">
                            <div class="col-md-6 mb-2">
                                <div class="row">
                                    <label for="stock" class="form-label col-sm-4">En stock:</label>
                                    <div class="col-sm-8">
                                        <input disabled type="text" name="stock" id="stock" class="form-control">
                                    </div>
                                </div>
                            </div>
                        </div>
                        <!--Cantidad-->
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>
                        <!--Precio de venta-->
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input disabled type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
                        </div>
                        <!--Descuento-->
                        <div class="col-md-4 mb-2">
                            <label for="descuento" class="form-label">Descuento:</label>
                            <input type="number" name="descuento" id="descuento" class="form-control">
                        </div>
                        <div class="col-md-12 mb-2 text-end">
                            <button id="btn_agregar" type="button" class="btn btn-primary">
                                Agregar
                            </button>
                        </div>
                        <div class="col-md-12">
                            <div class="table-responsive">
                                <table id="tabla_detalle" class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>#</th>
                                            <th>Producto</th>
                                            <th>Cantidad</th>
                                            <th>Precio de venta</th>
                                            <th>Descuento</th>
                                            <th>Subtotal</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        <tr>
                                            <th></th>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                            <td></td>
                                        </tr>
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Sumas</th>
                                            <th colspan="2"><span id="sumas">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">IGV %</th>
                                            <th colspan="2"><span id="igv">0</span></th>
                                        </tr>
                                        <tr>
                                            <th></th>
                                            <th colspan="4">Total</th>
                                            <th colspan="2"><input type="hidden" name="total" value="0" id="inputTotal"><span id="total">0</span></th>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                        <div class="col-md-12 mb-2">
                            <button id="cancelar" type="button" class="btn btn-danger" data-bs-toggle="modal" data-bs-target="#exampleModal">
                                Cancelar venta
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="text-white bg-success p-1 text-center">
                    Datos generales
                </div>
                <div class="p-3 border border-3 border-success">
                    <div class="row">
                        <!--Cliente-->
                        <div class="col-md-12 mb-2">
                            <label for="cliente_id" class="form-label">Cliente:</label>
                            <select name="cliente_id" id="cliente_id" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione" data-size="3">
                                @foreach ($clientes as $item)
                                <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('cliente_id')
                            <small class="text_danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <!--Tipo de comprobante-->
                        <div class="col-md-12 mb-2">
                            <label for="comprobante_id" class="form-label">Tipo de comprobante:</label>
                            <select name="comprobante_id" id="comprobante_id" class="form-control selectpicker show-tick" title="Seleccione">
                                @foreach ($comprobantes as $item)
                                <option value="{{$item->id}}">{{$item->tipo_comprobante}}</option>
                                @endforeach
                            </select>
                            @error('comprobante_id')
                            <small class="text_danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <!--Numero de comprobante-->
                        <div class="col-md-8 mb-2">
                            <label for="numero_comprobante" class="form-label">N° de comprobante:</label>
                            <input required type="text" name="numero_comprobante" id="numero_comprobante" class="form-control">
                            @error('numero_comprobante')
                            <small class="text_danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <!--Impuesto-->
                        <div class="col-md-8 mb-2">
                            <label for="impuesto" class="form-label">Impuesto (%):</label>
                            <input type="number" name="impuesto" id="impuesto" class="form-control" step="0.01" placeholder="Ingrese el impuesto">
                            @error('impuesto')
                            <small class="text_danger">{{'*'.$message}}</small>
                            @enderror
                        </div>
                        <!--Fecha-->
                        <div class="col-md-8 mb-2">
                            <label for="fecha" class="form-label">Fecha:</label>
                            <input readonly type="date" name="fecha" id="fecha" class="form-control border-success" value="<?php echo date("Y-m-d") ?>">
                            <?php

                            use Carbon\Carbon;

                            $fecha_hora = Carbon::now()->toDateTimestring();
                            ?>
                            <input type="hidden" name="fecha_hora" value="{{$fecha_hora}}">
                        </div>
                        <!--User-->
                        <input type="hidden" name="user_id" value="{{ auth()->user()->id }}">
                        <div class="col-md-12 mb-2 text-center">
                            <button type="submit" class="btn btn-success" id="guardar">
                                Guardar
                            </button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- modal de cancelar venta -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmacion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que desea cancelar la venta?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id="btnCancelarVenta" type="button" class="btn btn-primary">Confirmar</button>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection
@push('js')
<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/js/bootstrap-select.min.js"></script>
<script>

$(document).ready(function() {
    $('#producto_id').change(mostrarValores);
    $('#btn_agregar').click(function() {
        agregarProducto();
    });
    
    //SECTION Actualizar lods totales cuando el usuario cambia el impuesto
    $('#impuesto').on('input', function() {
        let porcentajeImpuesto = parseFloat($(this).val()) || 0;
        calcularTotales(porcentajeImpuesto);
    });
    $('#btnCancelarVenta').click(function() {
        cancelarVenta();
    });
    disableButtons();
    $('#impuesto').val(impuesto + '%');
});

let cont = 0;
let subtotal = [];
let totalSinImpuesto = 0;
let totalConImpuesto = 0;

function mostrarValores() {
    let dataProduct = document.getElementById('producto_id').value.split('-');
    $('#stock').val(dataProduct[1]);
    $('#precio_venta').val(dataProduct[2]);
}

function agregarProducto() {
    let dataProduct = document.getElementById('producto_id').value.split('-');
    let idProducto = dataProduct[0];
    let nameProducto = $('#producto_id option:selected').text();
    let cantidad = $('#cantidad').val();
    let precioVenta = $('#precio_venta').val();
    let descuento = $('#descuento').val();
    let stock = $('#stock').val();

    if (descuento == '') {
        descuento = 0;
    }

    if (idProducto != '' && cantidad != '') {
        if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(descuento) >= 0) {
            if (parseFloat(cantidad) <= parseFloat(stock)) {
                subtotal[cont] = (cantidad * precioVenta) - descuento;
                totalSinImpuesto += subtotal[cont];
                
                let fila = `<tr id="fila${cont}">
                    <th>${cont + 1}</th>
                    <td><input type="hidden" name="arrayidproducto[]" value="${idProducto}">${nameProducto}</td>
                    <td><input type="hidden" name="arraycantidad[]" value="${cantidad}">${cantidad}</td>
                    <td><input type="hidden" name="arrayprecioventa[]" value="${precioVenta}">${precioVenta}</td>
                    <td><input type="hidden" name="arraydescuento[]" value="${descuento}">${descuento}</td>
                    <td>${subtotal[cont]}</td>
                    <td><button class="btn btn-danger" type="button" onClick="eliminarProducto(${cont})"><i class="fa-solid fa-trash"></i></button></td>
                </tr>`;
                
                $('#tabla_detalle').append(fila);
                limpiarCampos();
                cont++;
                
                // Calcular totales
                calcularTotales(parseFloat($('#impuesto').val()) || 0);
            } else {
                showModal('Cantidad incorrecta', 'error');
            }
        } else {
            showModal('Valores incorrectos', 'error');
        }
    } else {
        showModal('Le faltan campos por llenar', 'error');
    }
}

function calcularTotales(impuesto) {
    //SECTION Calcular el total con impuesto
    totalConImpuesto = totalSinImpuesto + (totalSinImpuesto * (impuesto / 100));

    $('#sumas').text(totalSinImpuesto.toFixed(2));
    $('#igv').text((totalSinImpuesto * (impuesto / 100)).toFixed(2));
    $('#total').text(totalConImpuesto.toFixed(2));
    $('#inputTotal').val(totalConImpuesto.toFixed(2)); 
}

function eliminarProducto(indice) {
    totalSinImpuesto -= subtotal[indice];  
    $('#fila' + indice).remove();  
    calcularTotales(parseFloat($('#impuesto').val()) || 0);  
}

function limpiarCampos() {
    $('#cantidad').val('');
    $('#precio_venta').val('');
    $('#descuento').val('');
}
function cancelarVenta() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¡Perderás todos los cambios!",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Sí, cancelar venta',
        cancelButtonText: 'No, seguir vendiendo'
    }).then((result) => {
        if (result.isConfirmed) {
            //SECTION Limpiar los campos del formulario
            $('#producto_id').val('').selectpicker('refresh');
            $('#cantidad').val('');
            $('#descuento').val('');
            $('#stock').val('');
            $('#precio_venta').val('');
            $('#tabla_detalle tbody').empty(); 
            $('#sumas').text('0');
            $('#igv').text('0');
            $('#total').text('0');
            $('#inputTotal').val('0');
            $('#impuesto').val(impuesto + '%');
            cont = 0; 
            Swal.fire(
                'Cancelado!',
                'La venta ha sido cancelada.',
                'success'
            )
        }
    });
}


function showModal(message, icon = 'error') {
    const Toast = Swal.mixin({
        toast: true,
        position: 'top-end',
        showConfirmButton: false,
        timer: 3000,
        timerProgressBar: true,
    });

    Toast.fire({
        icon: icon,
        title: message,
    });
}

</script>
@endpush