<div class="row">
  <div class="form-group col-sm btn-sm">
    <label for="lider_de_pedido_logistica">{{ __('Líder de pedido logística') }} *</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-text-width"></i></i></span>
      </div>
      {!! Form::text('lider_de_pedido_logistica', $pedido->lid_de_ped_log, ['class' => 'form-control' . ($errors->has('lider_de_pedido_logistica') ? ' is-invalid' : ''), 'maxlength' => 80, 'placeholder' => __('Líder de pedido logística')]) !!}
    </div>
    <span class="text-danger">{{ $errors->first('lider_de_pedido_logistica') }}</span>
  </div>
</div>
<div class="row">
  <div class="form-group col-sm btn-sm">
    <label for="comentario_logistica">{{ __('Comentario logística') }}</label>
    <div class="input-group">
      <div class="input-group-prepend">
        <span class="input-group-text"><i class="fas fa-text-width"></i></span>
      </div>
      {!! Form::textarea('comentario_logistica', $pedido->coment_log, ['class' => 'form-control' . ($errors->has('comentario_logistica') ? ' is-invalid' : ''), 'maxlength' => 30000, 'placeholder' => __('Comentario logística'), 'rows' => 4, 'cols' => 4]) !!}
    </div>
    <span class="text-danger">{{ $errors->first('comentario_logistica') }}</span>
  </div>
</div>