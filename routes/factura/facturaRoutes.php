<?php
/* ===================== [ RUTAS (USUARIO) ] ===================== */
Route::group(['prefix' => 'factura'], function() {
    Route::match(['GET', 'HEAD'],'', 'Factura\FacturaController@index')->name('factura.index')->middleware('permission:factura.index|factura.create|factura.show|factura.edit|factura.destroy');
    Route::match(['GET', 'HEAD'],'crear', 'Factura\FacturaController@create')->name('factura.create')->middleware('permission:factura.create');
    Route::post('almacenar', 'Factura\FacturaController@store')->name('factura.store')->middleware('permission:factura.create');
    Route::match(['GET', 'HEAD'],'detalles/{id_factura}', 'Factura\FacturaController@show')->name('factura.show')->middleware('permission:factura.show');
    Route::match(['GET', 'HEAD'],'editar/{id_factura}', 'Factura\FacturaController@edit')->name('factura.edit')->middleware('permission:factura.edit');
    Route::match(['PUT', 'PATCH'],'actualizar/{id_factura}', 'Factura\FacturaController@update')->name('factura.update')->middleware('permission:factura.edit');
    Route::match(['DELETE'],'eliminar/{id_factura}', 'Factura\FacturaController@destroy')->name('factura.destroy')->middleware('permission:factura.destroy');
    Route::match(['GET', 'HEAD'],'subir-archivos/{id_factura}', 'Factura\FacturaController@subirArchivos')->name('factura.subirArchivos')->middleware('permission:factura.edit');
});