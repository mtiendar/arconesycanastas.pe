<td width="1rem" title="Editar: {{ $direccion->est }}">
  <a href="{{ route('rolFerro.envioLocal.edit', Crypt::encrypt($direccion->id)) }}" class='btn btn-light btn-sm'><i class="fas fa-edit"></i></a>
</td>