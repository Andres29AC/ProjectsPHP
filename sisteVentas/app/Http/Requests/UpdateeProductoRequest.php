<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateeProductoRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $producto = $this->route('producto');
        return [
            'codigo' => 'required|unique:productos,codigo,'.$producto->id.'|max:60',
            'nombre' => 'required|unique:productos,nombre,'.$producto->id.'|max:80',
            'descripcion' => 'nullable|max:255',
            'fecha_vencimiento' => 'nullable|date',
            'img_path' => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
            'marca_id' => 'required|integer|exists:marcas,id',
            'presentacion_id' => 'required|integer|exists:presentaciones,id',
            'categorias' => 'required',
        ];
    }
    public function attributes()
    {
        return[
            'marca_id' => 'marca',
            'presentacion_id' => 'presentacion',
        ];
    }
    //NOTE: Mensajes personalizados
    public function message(){
        return[
            'codigo.required' => 'El campo codigo es requerido',
        ];
    }
}
