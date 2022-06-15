@extends('adminlte::page')
<?php
session_start();
?>

@section('title', 'Carrinho')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Gerenciamento</li>
                <li class="breadcrumb-item active">Carrinho</li>
            </ol>
        </div>
    </div>
@stop

@section('content')

    <div class="row">
        <div class="col-12">
            @if (session()->has('create'))
                <div class="alert alert-success">
                    {{ session()->get('create') }}
                </div>
            @endif
            @if (session()->has('delete'))
                <div class="alert alert-danger">
                    {{ session()->get('delete') }}
                </div>
            @endif
            @if (session()->has('update'))
                <div class="alert alert-primary">
                    {{ session()->get('update') }}
                </div>
            @endif
            @if (session()->has('error'))
                <div class="alert alert-danger">
                    {{ session()->get('error') }}
                </div>
            @endif
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Lista de Produtos</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" value="{{$venda->id}}" id="venda">
                    <input type="hidden" value="{{$venda->empresaid}}" id="empresa">
                    <div class="row" style="padding-bottom: 1rem;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="descricao">Cliente</label>
                                <select type="text" id="cliente" class="form-control" name="cliente">
                                    <option value="">Nenhum Cliente</option>
                                    @foreach($clientes as $cliente)
                                    <option value="{{$cliente->id}}">{{$cliente->nome}}</option>
                                    @endforeach
                                </select>
                            </div>
                        </div>   
                        <div class="col-md-9">
                            <label for="descricao">Codigo do Produto</label>
                            <div class="input-group">
                                <input type="text" class="form-control" name="produto" id="produto" autofocus>
                                <div class="input-group-append">
                                <span class="input-group-text btnsearch" onclick="btnsearch()" id="btnsearch" style="cursor: pointer; :hover { background-color: yellow};"><i class="fas fa-search"></i></span>
                                </div>
                            </div>
                        </div>   
                    </div>
                    <table class="table table-striped" id="tabelaproduto" style="width: 100%">
                        <thead>
                            <tr>
                                <td>Produto</td>
                                <td>Quantidade</td>
                                <td>Valor</td>
                                <td>Ações</td>
                            </tr>
                        </thead>
                        <tbody id="tbodyproduto">
                            @foreach($itensvendas as $item)
                            <tr id="{{$item->produto->id}}"> 
                                <td>{{$item->produto->nome}}</td>
                                <td>
                                    1
                                 </td>
                                <td><input class="dinheiroitem form-control"  data-codigolista="{{$item->id}}"  value="{{number_format($item->valor, 2, ",", ".") ?? 0}}"></td>
                                <td>
                                <button type="button" class="btn btn-danger" onclick="removerproduto({{$item->produto->id}}, {{$item->vendaid}}, {{$item->produto->codigodebarraunico}})">
                                    Remover
                                </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span style="font-weight: bolder;"> Valor Total: <span id="valortotal">{{$total ?? 'error'}}</span> <span>
                    <button type="submit" class="btn btn-success float-right" onclick="finalizarvenda({{$venda->id}})">Finalizar Compra</button>
                </div>
            </div>
        </div>
    </div>

    <div class="modal" id="searchmodal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Produtos</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <table class="table table-striped" id="produtostabela" style="width: 100%">
                        <thead>
                            <tr>
                                <td>Produto</td>
                                <td>Codigo de Barra</td>
                                <td>Valor</td>
                                <td>Ações</td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($produtos as $produto)
                            <tr id="produtos{{$produto->codigodebarraunico}}"> 
                                <td>{{$produto->nome}}</td>
                                <td>
                                    {{$produto->codigodebarraunico}}
                                 </td>
                                <td>{{number_format($produto->valorvenda, 2, ",", ".") ?? 'error'}}</td>
                                <td>
                                <button type="button" data-codebar="{{$produto->codigodebarraunico}}" class="btn btn-primary adicionarproduto">
                                    Adicionar Produto
                                </button>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>  
                <input type="hidden" name="empresa_id" id="empresa_id" value="">
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                </div>
            </div>
        </div>
    </div>

@stop

@section('css')
    <link rel="stylesheet" type="text/css"
        href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.0.0-alpha1/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        .btnqtd{
            cursor: pointer;
        }

        .btnqtd i{
            color: #696969;
        }

        .btnqtd i:hover{
            color: #808080;
        }

        .select2-selection__rendered {
        line-height: 31px !important;
        }
        .select2-container .select2-selection--single {
            height: 35px !important;
        }
        .select2-selection__arrow {
            height: 34px !important;
        }
        .btnsearch:hover{
            background-color: #C4C4C4;
        }
        .dinheiroitem{
            width: 6rem;
        }
    </style>
@stop

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.js" integrity="sha512-2Pv9x5icS9MKNqqCPBs8FDtI6eXY0GrtBy8JdSwSR4GVlBWeH5/eqXBFbwGGqHka9OABoFDelpyDnZraQawusw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
     $(".dinheiroitem").mask("###.###.##0,00", { reverse: true, maxlength: true });
    
    
     $(document).on("focusout",".dinheiroitem", function() {
        if($(this).val() == ''){
            $(this).val(0);
        }
        let valor = $(this).val().replace(/([^\d])+/g, '') / 100;
        let id =  $(this).data("codigolista");
            $.ajax({
                    data: { id: id, valor: valor, empresa: $("#empresa").val()},
                    url: "/alterarvalor/compra",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#valortotal').html(data.total);
                    },
                    error: function (data) {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.responseText
                        });
                    }
                });
    }) 
    $("#produto").keypress(function(event) {
        if(event.keyCode == '13') {
            $.ajax({
                    data: { codigo: $(this).val(), venda: $("#venda").val()},
                    url: "/adicionarproduto/venda",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $("#tbodyproduto").append(data.view);
                        $('#valortotal').html(data.total);
                        $(this).val('');
                    },
                    error: function (data) {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.responseText
                        });
                    }
                });
        }
    });

    $(document).on("click",".adicionarproduto", function () {
        let codigobarra = $(this).data("codebar");
        $.ajax({
                    data: { codigo: $(this).data("codebar"), venda: $("#venda").val()},
                    url: "/adicionarproduto/venda",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $("#tbodyproduto").append(data.view);
                        $('#valortotal').html(data.total);
                        $('#produtos'+codigobarra).hide();
                        $(this).val('');
                    },
                    error: function (data) {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.responseText
                        });
                    }
        });
        $("#searchmodal").modal('toggle');
    });

    function finalizarvenda(vendaid){
            Swal.fire({
                title: 'Deseja finalizar a venda?',
                text: "Essa ação não é reversiva!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Não',
                confirmButtonText: 'Sim, finalizar venda!'
                }).then((result) => {
                if (result.value) {
                    window.location.href = '/finalizar/venda/'+vendaid;
                }
            })
    }

    function btnsearch(){
        $("#searchmodal").modal('show');
    }

    function removerproduto(id, venda, codigobarra){
            if(id != ''){
                $.ajax({
                    data: { produto: id, venda: venda },
                    url: "/removerproduto/venda",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function (data) {
                        $('#'+data.id).remove();
                        $('#valortotal').html(data.total);
                        console.log('#produtos'+codigobarra);
                        $('#produtos'+codigobarra).show();
                    },
                    error: function (data) {
                        Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: data.responseText
                        });
                    }
                });
            }else{
                console.log("PREENCHA OS CAMPOS");
            }
        }

        $(document).ready(function() {
            $("#cliente").select2();
            $("#tabelaproduto").DataTable({
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });

            $("#produtostabela").DataTable({
                "language": {
                    "sEmptyTable": "Nenhum registro encontrado",
                    "sInfo": "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                    "sInfoEmpty": "Mostrando 0 até 0 de 0 registros",
                    "sInfoFiltered": "(Filtrados de _MAX_ registros)",
                    "sInfoPostFix": "",
                    "sInfoThousands": ".",
                    "sLengthMenu": "_MENU_ resultados por página",
                    "sLoadingRecords": "Carregando...",
                    "sProcessing": "Processando...",
                    "sZeroRecords": "Nenhum registro encontrado",
                    "sSearch": "Pesquisar",
                    "oPaginate": {
                        "sNext": "Próximo",
                        "sPrevious": "Anterior",
                        "sFirst": "Primeiro",
                        "sLast": "Último"
                    },
                    "oAria": {
                        "sSortAscending": ": Ordenar colunas de forma ascendente",
                        "sSortDescending": ": Ordenar colunas de forma descendente"
                    }
                }
            });

        });
    </script>
    

@stop
