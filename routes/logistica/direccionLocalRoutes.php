<?php
/* ===================== [ RUTAS LOGÍSTICA (ARMADOS LOCALES) ] ===================== */
Route::group(['prefix' => 'local'], function() {
  Route::match(['GET', 'HEAD'],'', 'Logistica\DireccionLocal\DireccionLocalController@index')->name('logistica.direccionLocal.index')->middleware('permission:logistica.direccionLocal.index|logistica.direccionLocal.show|logistica.direccionLocal.edit');
  Route::match(['GET', 'HEAD'],'detalles/{id_direccion}', 'Logistica\DireccionLocal\DireccionLocalController@show')->name('logistica.direccionLocal.show')->middleware('permission:logistica.direccionLocal.show');

  Route::group(['prefix' => 'comprobante-de-salida'], function() {
    Route::match(['GET', 'HEAD'],'registrar/{id_direccion}', 'Logistica\DireccionLocal\DireccionLocalController@create')->name('logistica.direccionLocal.create')->middleware('permission:logistica.direccionLocal.create');
    Route::post('almacenar/{id_direccion}', 'Logistica\DireccionLocal\DireccionLocalController@store')->name('logistica.direccionLocal.store')->middleware('permission:logistica.direccionLocal.create');
  });

  Route::group(['prefix' => 'comprobante-de-entrega'], function() {
    Route::match(['GET', 'HEAD'],'registrar/{id_comprobante}', 'Logistica\DireccionLocal\DireccionLocalController@createEntrega')->name('logistica.direccionLocal.createEntrega')->middleware('permission:logistica.direccionLocal.create');
    Route::post('almacenar/{id_comprobante}', 'Logistica\DireccionLocal\DireccionLocalController@storeEntrega')->name('logistica.direccionLocal.storeEntrega')->middleware('permission:logistica.direccionLocal.create');
  });
});