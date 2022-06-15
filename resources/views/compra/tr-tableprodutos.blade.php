
    <tr id="{{$produto->id}}"> 
        <td>{{$produto->produto->nome}}</td>
        <td>{{$produto->codigodebarra ?? ''}}</td>
        <td style="text-align: center;">
            @if(!$produto->codigodebarra)
            <span class="btnqtd" style="padding-right: 0.4rem;" onclick="removerquantidadeproduto('{{$produto->id}}', {{$produto->compraid}})">
                <i class="fas fa-minus-circle"></i>
            </span>
            @endif
            <span id="qtd{{$produto->id}}">
                {{$produto->quantidade ?? 'error'}}
            </span>
            @if(!$produto->codigodebarra)
            <span class="btnqtd" style="padding-left: 0.4rem;" onclick="adicionarquantidadeproduto('{{$produto->id}}', {{$produto->compraid}})">
                <i class="fas fa-plus-circle"></i>
            </span>
            @endif
        </td>
        <td>{{number_format($produto->valor, 2, ",", ".") ?? 'error'}}</td>
        <td>
        <button type="button" class="btn btn-danger" onclick="removerproduto('{{$produto->id}}', {{$produto->compraid}})">
            Remover
        </button>
        </td>
    </tr>