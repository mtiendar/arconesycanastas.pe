@extends('layouts.private.escritorio.dashboard')
@section('contenido')
<title>@section('title', __('Registrar comprobante de entrega').' '.$direccion->est)</title>
<div class="card {{ config('app.color_card_primario') }} card-outline card-tabs position-relative bg-white">
  <div class="card-header p-1 border-bottom {{ config('app.color_bg_primario') }}">
    <h5>
      <strong>{{ __('Registrar comprobante de entrega') }}: </strong>{{ $direccion->est }} ({{ Sistema::dosDecimales($direccion->cant) }})
    </h5>
  </div>
  <div class="ribbon-wrapper">
    <div class="ribbon {{ config('app.color_bg_primario') }}"> 
      <small>{{ $direccion->est }}</small>
    </div>
  </div>
  <div class="card-body">
    <form @submit.prevent="create" enctype="multipart/form-data">
      @include('logistica.pedido.direccion_local.comprobante.com_createEntregaFields')
      <div class="row">
        <div class="form-group col-sm btn-sm">
          <a href="{{ route('logistica.direccionLocal.index') }}" class="btn btn-default w-50 p-2 border"><i class="fas fa-sign-out-alt text-dark"></i> {{ __('Regresar') }}</a>
        </div>
        <div class="form-group col-sm btn-sm">
          <button type="submit" id="btnsubmit" class="btn btn-info w-100 p-2"><i class="fas fa-check-circle text-dark"></i> {{ __('Registrar') }}</button>
        </div>
      </div>
    </form>
  </div>
</div>
@endsection

@section('css')
<style>
  #my_camera{
    width: 320px;
    height: 240px;
    border: 1px solid black;
  }
</style>
@endsection

@section('vuejs')
<script src="{{ asset('plugins/webcam-js/webcamjs/webcam.min.js') }}"></script>
<script>
  var app4 = new Vue({
    el: '#dashboard',
    data: {
      errors: [],
      numero_de_guia: [],
      costo_por_envio:  [],
      mydataComprobantdeentrega: null,
      metodo_de_entrega: "{{ $direccion->met_de_entreg_de_log }}"
    },
    methods: {
       create() {
        this.checarBotonSubmitDisabled("btnsubmit") 
        fetch(mydataComprobantdeentrega.value)
          .then(res => res.blob())
          .then(blob => {
            const formData = new FormData()
            formData.append('numero_de_guia', this.numero_de_guia)
            formData.append('comprobante_de_entrega', blob, 'filename')
            formData.append('costo_por_envio', this.costo_por_envio)
            formData.append('mydataComprobantdeentrega', this.mydataComprobantdeentrega)
            formData.append('metodo_de_entrega', this.metodo_de_entrega)
            
            axios.post('/logistica/direccion/local/comprobante-de-entrega/almacenar/'+{{ $direccion->id }}, formData, {
              headers: {
                'Content-Type': 'multipart/form-data'
              }
            }).then(res => {
              Swal.fire({
                title: 'Éxito',
                text: '¡Comprobante registrado exitosamente!',
              }).then((value) => {
                location.href="{{ route('logistica.direccionLocal.index') }}";
                //  location.reload()
              })
            }).catch(error => {
              this.checarBotonSubmitEnabled("btnsubmit")
              if(error.response.status == 422) {
                this.errors = error.response.data.errors
              } else {
                Swal.fire({
                  title: 'Algo salio mal',
                  text: error,
                })
              }
            });
         });
      },
      async checarBotonSubmitDisabled(id_btn) {
        document.getElementById(id_btn).value = "Espere un momento...";
        document.getElementById(id_btn).disabled = true;
        return true;
      },
      async checarBotonSubmitEnabled(id_btn) {
        document.getElementById(id_btn).value = "Espere un momento...";
        document.getElementById(id_btn).disabled = false;
        return true;
      },
      async quitarFoto(mydata, results) {
        document.getElementById(mydata).value = '';
        document.getElementById(results).innerHTML = 
            '<img src=""/>';
      },
      async capturarFoto(mydata, results) {
        var data_uri = Webcam.snap( function(data_uri, canvas, context) {
          document.getElementById(mydata).value = data_uri;
          document.getElementById(results).innerHTML = 
            '<img src="'+data_uri+'"/>';
        });
      },
    }
  });
  Webcam.set({
    width: 320,
    height: 240,
    dest_width: 640,
    dest_height: 480,
    image_format: 'jpeg',
    jpeg_quality: 90,
    force_flash: false
  });
  Webcam.attach('#my_camera_comprobante_de_entrega');
</script>
@endsection