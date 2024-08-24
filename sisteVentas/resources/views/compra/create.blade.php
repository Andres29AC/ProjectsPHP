@extends('template')
@section('title','Crear compra')
@push('css')
<style>
    thead {
        border-bottom: 2px solid rgb(160 160 160);
        text-align: center;
        background-color: rgb(160 160 160);
        color: black;
        font-style: italic;
    }
</style>
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.14.0-beta3/dist/css/bootstrap-select.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
@endpush
@section('content')
<div class="container-fluid px-4">
    <h1 class="mt-4 text-center">Crear Compra</h1>
    <ol class="breadcrumb mb-4">
        <li class="breadcrumb-item"><a href="{{route('panel')}}">Inicio</a></li>
        <li class="breadcrumb-item "><a href="{{route('compras.index')}}">Compra</a></li>
        <li class="breadcrumb-item active">Crear Compra</li>
    </ol>
</div>
<form action="{{route('compras.store')}}" method="post">
    @csrf
    <div class="container mt-4">
        <div class="row gy-4">
            <div class="col-md-8">
                <div class="text-white bg-primary p-1 text-center">
                    Detalles de la compra
                </div>
                <div class="p-3 border border-3 border-primary">
                    <div class="row">
                        <!--Producto-->
                        <div class="col-md-12 mb-2">
                            <select name="producto_id" id="producto_id" class="form-control selectpicker show-tick" data-live-search="true" title="Busque un producto aqui" data-size="3">
                                @foreach ($productos as $item)
                                <option value="{{$item->id}}">{{$item->codigo.' '.$item->nombre}}</option>
                                @endforeach
                            </select>
                        </div>
                        <!--Cantidad-->
                        <div class="col-md-4 mb-2">
                            <label for="cantidad" class="form-label">Cantidad:</label>
                            <input type="number" name="cantidad" id="cantidad" class="form-control">
                        </div>
                        <!--Precio de compra-->
                        <div class="col-md-4 mb-2">
                            <label for="precio_compra" class="form-label">Precio de compra:</label>
                            <input type="number" name="precio_compra" id="precio_compra" class="form-control" step="0.1">
                        </div>
                        <!--Precio de venta-->
                        <div class="col-md-4 mb-2">
                            <label for="precio_venta" class="form-label">Precio de venta:</label>
                            <input type="number" name="precio_venta" id="precio_venta" class="form-control" step="0.1">
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
                                            <th>Precio de compra</th>
                                            <th>Precio de venta</th>
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
                                Cancelar compra
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
                        <!--Proveedor-->
                        <div class="col-md-12 mb-2">
                            <label for="proveedore_id" class="form-label">Proveedor:</label>
                            <select name="proveedore_id" id="proveedore_id" class="form-control selectpicker show-tick" data-live-search="true" title="Seleccione" data-size="3">
                                @foreach ($proveedores as $item)
                                <option value="{{$item->id}}">{{$item->persona->razon_social}}</option>
                                @endforeach
                            </select>
                            @error('proveedore_id')
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
                            @error('proveedore_id')
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
                        <!--
                        <div class="col-md-8 mb-2">
                            <label for="impuesto" class="form-label">Impuesto:</label>
                            <input readonly type="text" name="impuesto" id="impuesto" class="form-control border-success">
                        </div>
                        -->
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
    <!-- modal de cancelar compra -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h1 class="modal-title fs-5" id="exampleModalLabel">Modal de confirmacion</h1>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    ¿Seguro que desea cancelar la compra?
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Cerrar</button>
                    <button id ="btnCancelar" type="button" class="btn btn-primary">Confirmar</button>
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
        $('#btn_agregar').click(function() {
            agregarProducto();
        });
        $('#btnCancelar').click(function() {
            cancelarCompra();
        });
        disabledButtons();
        $('#impuesto').on('input', function() {
            let porcentajeImpuesto = parseFloat($(this).val()) || 0;
            calcularTotales(porcentajeImpuesto);
        });
    });
    let cont = 0;
    let subtotal = {};
    let suma = 0;
    let igv = 0;
    let total = 0;
    function cancelarCompra() {
        $('#tabla_detalle tbody tr').remove();
        limpiarCampos();
        cont = 0;
        subtotal = {};
        suma = 0;
        igv = 0;
        total = 0;
        $('#sumas').text(suma.toFixed(2));
        $('#igv').text(igv.toFixed(2));
        $('#total').text(total.toFixed(2));
        $('#exampleModal').modal('hide');
        $('#inputTotal').val(total);

        disabledButtons();
    }
    function disabledButtons(){
        if(total == 0){
            $('#guardar').prop('disabled', true);
            $('#cancelar').prop('disabled', true);
        }else{
            $('#guardar').prop('disabled', false);
            $('#cancelar').prop('disabled', false);
        }
    }
    function agregarProducto() {
        let idProducto = $('#producto_id').val();
        let nameProducto = ($('#producto_id option:selected').text()).split(' ')[1];
        let cantidad = $('#cantidad').val();
        let precioCompra = $('#precio_compra').val();
        let precioVenta = $('#precio_venta').val();
        //Validaciones
        if (nameProducto != '' && cantidad != '' && precioCompra != '' && precioVenta != '') {
            if (parseInt(cantidad) > 0 && (cantidad % 1 == 0) && parseFloat(precioCompra) > 0 && parseFloat(precioVenta) > 0) {
                if (parseFloat(precioVenta) > parseFloat(precioCompra)) {
                    subtotal[cont] = cantidad * precioCompra;
                    let fila = '<tr id="fila' + cont + '">' +
                        '<th>' + (cont + 1) + '</th>' +
                        '<td><input type="hidden" name="arrayidproducto[]" value="' + idProducto + '">' + nameProducto + '</td>' +
                        '<td><input type="hidden" name="arraycantidad[]" value="' + cantidad + '">' + cantidad + '</td>' +
                        '<td><input type="hidden" name="arraypreciocompra[]" value="' + precioCompra + '">' + precioCompra + '</td>' +
                        '<td><input type="hidden" name="arrayprecioventa[]" value="' + precioVenta + '">' + precioVenta + '</td>' +
                        '<td>' + subtotal[cont] + '</td>' +
                        '<td><button type="button" class="btn btn-danger" onClick="eliminarProducto(' + cont + ')"><i class="fa-solid fa-trash-can"></i></button></td>' +
                        '</tr>';
                    $('#tabla_detalle').append(fila);
                    limpiarCampos();
                    cont++;
                    let porcenImpuesto = parseFloat($('#impuesto').val()) || 0;
                    calcularTotales(porcenImpuesto);
                    disabledButtons();
                } else {
                    showModal('El precio de venta debe ser mayor al precio de compra', 'error');
                }
            } else {
                showModal('Ingrese datos correctos', 'error');
            }
        } else {
            showModal('Complete todos los campos', 'error');
        }
    }

    function eliminarProducto(indice) {
        delete subtotal[indice];
        $('#fila' + indice).remove();
        let porcenImpuesto = parseFloat($('#impuesto').val()) || 0;
        calcularTotales(porcenImpuesto);
        disabledButtons();
    }

    function limpiarCampos() {
        let select = $('#producto_id');
        select.selectpicker();
        select.selectpicker('val', '');
        $('#cantidad').val('');
        $('#precio_compra').val('');
        $('#precio_venta').val('');
        //$('#impuesto').val('');
    }

    function calcularTotales(porcentajeImpuesto) {
        suma = Object.values(subtotal).reduce((acc, val) => acc + val, 0);
        igv = suma * (porcentajeImpuesto / 100);
        total = suma + igv;

        $('#sumas').text(suma.toFixed(2));
        $('#igv').text(igv.toFixed(2));
        $('#total').text(total.toFixed(2));
        $('#inputTotal').val(total);
        disabledButtons();
    }

    function showModal(message, icon = 'error') {
        const Toast = Swal.mixin({
            toast: true,
            position: "top-end",
            showConfirmButton: false,
            timer: 3000,
            timerProgressBar: true,
            didOpen: (toast) => {
                toast.onmouseenter = Swal.stopTimer;
                toast.onmouseleave = Swal.resumeTimer;
            }
        });
        Toast.fire({
            icon: icon,
            title: message
        });
    }
</script>
@endpush