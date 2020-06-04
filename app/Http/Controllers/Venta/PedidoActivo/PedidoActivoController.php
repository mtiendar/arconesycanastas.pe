<?php
namespace App\Http\Controllers\Venta\PedidoActivo;
use App\Http\Controllers\Controller;
// Request
use Illuminate\Http\Request;
use App\Http\Requests\venta\pedidoActivo\UpdatePedidoRequest;
// Repositories
use App\Repositories\venta\pedidoActivo\PedidoActivoRepositories;

class PedidoActivoController extends Controller {
  protected $pedidoActivoRepo;
  public function __construct(PedidoActivoRepositories $pedidoActivoRepositories) {
    $this->pedidoActivoRepo = $pedidoActivoRepositories;
  }
  public function index(Request $request) {
    $pedidos = $this->pedidoActivoRepo->getPagination($request, ['usuario', 'unificar']);
    return view('venta.pedido.pedido_activo.ven_pedAct_index', compact('pedidos'));
  }
  public function show($id_pedido) {
    $pedido         = $this->pedidoActivoRepo->pedidoAsignadoFindOrFailById($id_pedido, ['usuario', 'unificar', 'armados', 'pagos']);
    $unificados     = $pedido->unificar()->paginate(99999999);
    $armados        = $this->pedidoActivoRepo->getArmadosPedidoPagination($pedido, (object) ['paginador' => 99999999, 'opcion_buscador' => null]);
    $pagos          = $this->pedidoActivoRepo->getPagosPedidoPagination($pedido, (object) ['paginador' => 99999999, 'opcion_buscador' => null]);
    $mont_pag_aprov =  $this->pedidoActivoRepo->getMontoDePagosAprobados($pedido);
    return view('venta.pedido.pedido_activo.ven_pedAct_show', compact('pedido', 'unificados', 'armados', 'pagos', 'mont_pag_aprov'));
  }
  public function edit($id_pedido) {
    $pedido         = $this->pedidoActivoRepo->pedidoAsignadoFindOrFailById($id_pedido, ['unificar', 'armados', 'pagos']);
    $unificados     = $pedido->unificar()->paginate(99999999);
    $armados        = $this->pedidoActivoRepo->getArmadosPedidoPagination($pedido, (object) ['paginador' => 99999999, 'opcion_buscador' => null]);
    $pagos          = $this->pedidoActivoRepo->getPagosPedidoPagination($pedido, (object) ['paginador' => 99999999, 'opcion_buscador' => null]);
    $mont_pag_aprov =  $this->pedidoActivoRepo->getMontoDePagosAprobados($pedido);
    return view('venta.pedido.pedido_activo.ven_pedAct_edit', compact('pedido', 'unificados', 'armados', 'pagos', 'mont_pag_aprov'));
  }
  public function update(UpdatePedidoRequest $request, $id_pedido) {
    $pedido = $this->pedidoActivoRepo->update($request, $id_pedido);
    toastr()->success('¡Pedido actualizado exitosamente!'); // Ruta archivo de configuración "vendor\yoeunes\toastr\config"
    return back();
  }
  public function destroy($id_pedido) {
    $this->pedidoActivoRepo->destroy($id_pedido);
    toastr()->success('¡Pedido eliminado exitosamente!'); // Ruta archivo de configuración "vendor\yoeunes\toastr\config"
    return back();
  }
}