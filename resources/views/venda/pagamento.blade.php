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
                    <form action="/adicionar/pagamento" method="POST">
                    @csrf
                    <input type="hidden" name="venda" value="{{$venda->id}}" id="venda">
                    <div class="row" style="padding-bottom: 1rem;">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label for="descricao">Forma de Pagamento</label>
                                <select type="text" id="forma" class="form-control" name="formadepagamento" required>
                                    <option value="Dinheiro">Dinheiro</option>
                                    <option value="Credito">Cartão de Credito</option>
                                    <option value="Debito">Cartão de Debito</option>
                                </select>
                            </div>
                        </div>   
                        <div class="col-md-9">
                            <label for="descricao">Valor</label>
                            <div class="input-group">
                                <input type="text" class="form-control dinheiro" name="valor" autofocus required>
                                <div class="input-group-append">
                                <button class="input-group-text btnsearch" type="submit" style="cursor: pointer;"><i class="fas fa-plus"></i></button>
                                </div>
                            </div>
                        </div>   
                    </div>
                    </form>
                    <table class="table table-striped" id="tabelapagamento" style="width: 100%">
                        <thead>
                            <tr>
                                <td>Valor</td>
                                <td>Forma de Pagamento</td>
                                <td>Ações</td>
                            </tr>
                        </thead>
                        <tbody id="tbodyproduto">
                            @foreach($pagametos as $pagamento)
                            <tr> 
                                <td>{{number_format($pagamento->valor, 2, ",", ".") ?? 'error'}}</td>
                                <td>{{$pagamento->forma_de_pagamento}}</td>
                                <td>
                                <a href="/remover/pagamento/{{$pagamento->id}}" class="btn btn-danger">
                                    Remover
                                </a>
                                </td>
                            <tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span style="font-weight: bolder;"> SubTotal Venda: {{$valores['subtotal'] ?? 'error'}} 
                        | Valor Restante:  {{$valores['valorRestante'] ?? 'error'}} 
                        | Troco: {{$valores['troco']}}
                    <span>
                    @if($valores['finalizar'])
                    <a href="/finalizar/pagamento/{{$venda->id}}" type="submit" class="btn btn-success float-right">Finalizar</a>
                    @endif
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
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itensvenda as $item)
                            <tr> 
                                <td>{{$item->produto->nome}}</td>
                                <td>
                                    {{$item->produto->codigodebarraunico}}
                                 </td>
                                <td>{{number_format($item->valor, 2, ",", ".") ?? 'error'}}</td>
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
    </style>
@stop

@section('js')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.js" integrity="sha512-2Pv9x5icS9MKNqqCPBs8FDtI6eXY0GrtBy8JdSwSR4GVlBWeH5/eqXBFbwGGqHka9OABoFDelpyDnZraQawusw==" crossorigin="anonymous" referrerpolicy="no-referrer"></script>
    <script type="text/javascript">
     
        $(document).ready(function() {
            $(".dinheiro").mask("###.###.##0,00", { reverse: true, maxlength: true });
            $("#tabelapagamento").DataTable({
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
