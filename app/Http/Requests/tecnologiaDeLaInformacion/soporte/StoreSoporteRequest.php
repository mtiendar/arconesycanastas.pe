<?php
namespace App\Http\Requests\tecnologiaDeLaInformacion\soporte;
use Illuminate\Foundation\Http\FormRequest;

class StoreSoporteRequest extends FormRequest {
  public function authorize() {
    return true;
  }
  public function rules() {
    return [
        'nombre_del_solicitante'    =>  'required|max:80',
        'empresa'                   =>  'required|max:80',
        'area_departamento'         =>  'required|max:80',
        'descripcion_de_la_falla'   =>  'required|max:30000|string',
    ];
  }
}