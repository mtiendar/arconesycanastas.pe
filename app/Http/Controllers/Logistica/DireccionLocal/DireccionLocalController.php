<?php
namespace App\Http\Controllers\Logistica\DireccionLocal;
use App\Http\Controllers\Controller;
// Request
use Illuminate\Http\Request;
use App\Http\Requests\logistica\direccionLocal\StoreComprobanteDeSalidaRequest;
use App\Http\Requests\logistica\direccionLocal\StoreComprobanteDeEntregaRequest;
// Repositories
use App\Repositories\logistica\direccionLocal\DireccionLocalRepositories;
use App\Repositories\metodoDeEntrega\MetodoDeEntregaRepositories;
use App\Repositories\venta\pedidoActivo\codigoQR\GenerarQRRepositories;

class DireccionLocalController extends Controller {
  protected $direccionLocalRepo;
  protected $comprobanteRepo;
  protected $generarQRRepo;
  public function __construct(DireccionLocalRepositories $direccionLocalRepositories, MetodoDeEntregaRepositories $metodoDeEntregaRepositories, GenerarQRRepositories $generarQRRepositories) {
    $this->direccionLocalRepo   = $direccionLocalRepositories;
    $this->metodoDeEntregaRepo  = $metodoDeEntregaRepositories;
    $this->generarQRRepo        = $generarQRRepositories;
  }
  public function index(Request $request) {
    $direcciones_locales = $this->direccionLocalRepo->getPagination($request, config('opcionesSelect.select_foraneo_local.Local'), ['armado']);
    return view('logistica.pedido.direccion_local.dirLoc_index', compact('direcciones_locales'));
  }




















  public function create($id_direccion) {
    $direccion          = $this->direccionLocalRepo->direccionLocalFindOrFailById($id_direccion, config('opcionesSelect.select_foraneo_local.Local'), [], 'edit');
    $metodos_de_entrega = $this->metodoDeEntregaRepo->getAllMetodosPluck('Local');
    return view('logistica.pedido.direccion_local.comprobante.com_createSalida', compact('direccion', 'metodos_de_entrega'));
  }
  public function store(StoreComprobanteDeSalidaRequest $request, $id_direccion) {
    $direccion = $this->direccionLocalRepo->store($request, $id_direccion);
    return $direccion;
  }
  public function createEntrega($id_direccion) { 
    $direccion          = $this->direccionLocalRepo->direccionLocalFindOrFailById($id_direccion, config('opcionesSelect.select_foraneo_local.Local'), [], 'edit');
    return view('logistica.pedido.direccion_local.comprobante.com_createEntrega', compact('direccion'));
  }
  public function storeEntrega(StoreComprobanteDeEntregaRequest $request, $id_direccion) {
    $direccion = $this->direccionLocalRepo->storeEntrega($request, $id_direccion);
    return $direccion;
  }



















  public function show($id_direccion) {
    $direccion = $this->direccionLocalRepo->direccionLocalFindOrFailById($id_direccion, config('opcionesSelect.select_foraneo_local.Local'), ['comprobantes'], 'show');
    $comprobantes = $direccion->comprobantes()->paginate(99999999);
    return view('logistica.pedido.direccion_local.dirLoc_show', compact('direccion', 'comprobantes'));
  }
  public function metodoDeEntregaEspecifico(Request $request, $metodo_de_entrega) {
    if( $request->ajax()) {
      $metodo_de_entrega = $this->metodoDeEntregaRepo->metodoFindOrFailByNombreMetodo($metodo_de_entrega, ['metodosDeEntregaEspecificos']);
      return $metodo_de_entrega->metodosDeEntregaEspecificos()->pluck('nom_met_ent_esp', 'nom_met_ent_esp');
    }
  }
  public function generarComprobanteDeEntrega($id_direccion, $for_loc) { // config('opcionesSelect.select_foraneo_local.Local')
    $direccion          = $this->direccionLocalRepo->direccionLocalFindOrFailById($id_direccion, $for_loc, ['armado'], 'show');
    if($direccion->nom_ref_uno == null) {
      return abort(403, 'No se ha definido la persona que recibe este pedido.');
    }
    $armado               = $direccion->armado;
    $codigoQRDComprobanteDeSalida = $this->generarQRRepo->qr($direccion->id, 'Comprobante de salida');
    $codigoQRDComprobanteDeEntrega = $this->generarQRRepo->qr($direccion->id, 'Comprobante de entrega');

    $comprobante_de_entrega  = \PDF::loadView('logistica.pedido.pedido_activo.export.comprobanteDeEntrega', compact('direccion', 'armado', 'codigoQRDComprobanteDeSalida', 'codigoQRDComprobanteDeEntrega'));
    return $comprobante_de_entrega->stream();
//  return $comprobante_de_entrega->download('OrdenDeProduccionAlmacen-'$pedido->num_pedido.'.pdf'); // Descargar
  }
}