@extends('layouts.private.escritorio.dashboard')
@section('contenido')
<title>@section('title', __('Editar pedido').' '.$pedido->num_pedido)</title>
<div class="card {{ empty($pedido->fech_de_entreg) ? config('app.color_card_danger') : config('app.color_card_primario') }} card-outline card-tabs position-relative bg-white">
  <div class="card-header p-1 border-bottom {{ empty($pedido->fech_de_entreg) ? config('app.color_bg_danger') : config('app.color_bg_primario') }}">
    <div class="float-right mr-5">
      <strong>{{ __('Estatus ventas') }}: </strong> @include('venta.pedido.pedido_activo.ven_pedAct_showFields.estatusVentas')
    </div>
    <h5>
      <strong>{{ __('Datos generales, estas en el pedido') }}:</strong>
      @can('venta.pedidoActivo.show')
        <a href="{{ route('venta.pedidoActivo.show', Crypt::encrypt($pedido->id)) }}" class="text-white">{{ $pedido->num_pedido }}</a>
      @else
        {{ $pedido->num_pedido }}
      @endcan
    </h5>
  </div>
  <div class="ribbon-wrapper">
    <div class="ribbon {{ empty($pedido->fech_de_entreg) ? config('app.color_bg_danger') : config('app.color_bg_primario') }}"> 
      <small>{{ $pedido->num_pedido }}</small>
    </div>
  </div>
</div>
@can('venta.pedidoActivo.edit')
  <div class="card {{ config('app.color_card_primario') }} card-outline card-tabs position-relative bg-white">
    <div class="card-body">
      {!! Form::open(['route' => ['venta.pedidoActivo.update', Crypt::encrypt($pedido->id)], 'method' => 'patch', 'id' => 'ventaPedidoActivoUpdate', 'files' => true]) !!}
        @include('venta.pedido.pedido_activo.ven_pedAct_editFields')
      {!! Form::close() !!}
    </div>
  </div>
@endcan
@include('venta.pedido.pedido_activo.armado_pedidoActivo.ven_arm_pedAct_index')
@include('venta.pedido.pedido_activo.pago_pedidoActivo.ven_pedAct_pag_index')
@endsection