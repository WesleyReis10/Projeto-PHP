
    <tr id="{{$produto->id}}"> 
        <td>{{$produto->nome}}</td>
        <td >
            1   
        </td>
        <td>
            <input class="dinheiroitem form-control"  data-codigolista="{{$item->id}}"  value="{{number_format($item->valor, 2, ",", ".") ?? 0}}">
        </td>
        <td>
        <button type="button" class="btn btn-danger" onclick="removerproduto({{$produto->id}}, {{$venda->id}}, {{$produto->codigodebarraunico}})">
            Remover
        </button>
        </td>
    </tr>