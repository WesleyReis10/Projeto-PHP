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
        <div class="col-md-4">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Produto</h3>
                </div>
                <div class="card-body">
                    <input type="hidden" id="compra" value="{{ $compra->id }}">
                    <div class="form-group">
                        <label for="produto">Produto</label>
                        <select class="form-select" id="produto" required autofocus>
                            <option value="" data-categoria="" data-marca=""> Selecione Produto </option>
                            @foreach ($produtos as $produto)
                                <option value="{{ $produto->id }}" data-categoria="{{ $produto->categoriaid }}"
                                    data-marca="{{ $produto->marcaid }}"> {{ $produto->nome }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="produto">Categoria</label>
                        <select class="form-select" id="categoria" disabled>
                            <option value="" name="categoria"> </option>
                            @foreach ($categorias as $categoria)
                                <option value="{{ $categoria->id }}"> {{ $categoria->nome }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="produto">Marca</label>
                        <select class="form-select" id="marca" disabled>
                            <option value="" name="marca"> </option>
                            @foreach ($marcas as $marca)
                                <option value="{{ $marca->id }}"> {{ $marca->nome }} </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label for="produto">Codigo Serial</label>
                        <input class="form-control" id="serialnumber">
                    </div>

                    <div class="form-group">
                        <label for="produto">Valor de Compra</label>
                        <input class="form-control dinheiro" id="valor">
                    </div>

                    <div class="form-group">
                        <label for="produto">Valor de Venda</label>
                        <input class="form-control dinheiro" id="valorvenda">
                    </div>

                    <div class="form-group">
                        <label for="produto">Quantidade</label>
                        <input class="form-control" id="quantidade" name="quantidade"
                            oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*?)\..*/g, '$1');">
                    </div>

                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-primary float-right"
                        onclick="adicionarProduto()">Adicionar</button>
                </div>
            </div>
        </div>
        <div class="col-md-8">
            <div class="card card-primary">
                <div class="card-header">
                    <h3 class="card-title">Lista de Produtos</h3>
                </div>
                <div class="card-body">
                    <table class="table table-striped" id="tabelaproduto" style="width: 100%">
                        <thead>
                            <tr>
                                <td>Produto</td>
                                <td>Serial Number</td>
                                <td>Quantidade</td>
                                <td>Valor</td>
                                <td>Ações</td>
                            </tr>
                        </thead>
                        <tbody id="tbodyproduto">
                            @foreach ($itenscompras as $produto)
                                <tr id="{{ $produto['id'] }}">
                                    <td>{{ $produto['produto']['nome'] }}</td>
                                    <td>{{ $produto['codigodebarra'] ?? '' }}</td>
                                    <td style="text-align: center;">
                                        @if (!$produto->codigodebarra)
                                            <span class="btnqtd" style="padding-right: 0.4rem;"
                                                onclick="removerquantidadeproduto('{{ $produto['id'] }}', {{ $produto['compraid'] }})">
                                                <i class="fas fa-minus-circle"></i>
                                            </span>
                                        @endif
                                        <span id="qtd{{ $produto['id'] }}">
                                            {{ $produto['quantidade'] ?? 'error' }}
                                        </span>
                                        @if (!$produto->codigodebarra)
                                            <span class="btnqtd" style="padding-left: 0.4rem;"
                                                onclick="adicionarquantidadeproduto('{{ $produto['id'] }}', {{ $produto['compraid'] }})">
                                                <i class="fas fa-plus-circle"></i>
                                            </span>
                                        @endif
                                    </td>
                                    <td>{{ number_format($produto['valor'], 2, ',', '.') ?? 'error' }}</td>
                                    <td>
                                        <button type="button" class="btn btn-danger"
                                            onclick="removerproduto('{{ $produto['id'] }}', {{ $produto['compraid'] }})">
                                            Remover
                                        </button>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="card-footer">
                    <span style="font-weight: bolder;"> Valor Total: <span id="valortotal">{{ $total ?? 'error' }}</span>
                        <span>
                            <button type="submit" class="btn btn-success float-right"
                                onclick="finalizarcompra({{ $compra->id }})">Finalizar Compra</button>
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
        .btnqtd {
            cursor: pointer;
        }

        .btnqtd i {
            color: #696969;
        }

        .btnqtd i:hover {
            color: #808080;
        }
    </style>
@stop

@section('js')

    <script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.8/jquery.mask.js"
        integrity="sha512-2Pv9x5icS9MKNqqCPBs8FDtI6eXY0GrtBy8JdSwSR4GVlBWeH5/eqXBFbwGGqHka9OABoFDelpyDnZraQawusw=="
        crossorigin="anonymous" referrerpolicy="no-referrer"></script>

    <script type="text/javascript">
        $('#produto').select2();

        $("#serialnumber").keyup(function() {
            if ($(this).val().length > 0) {
                $('#quantidade').val(1);
                $('#quantidade').prop("disabled", true);
            } else {
                $('#quantidade').prop("disabled", false);
            }
        });

        $("#quantidade").keyup(function() {
            if ($(this).val() > 1) {
                $('#serialnumber').val("");
                $('#serialnumber').prop("disabled", true);
            } else {
                $('#serialnumber').prop("disabled", false);
            }
        });

        $("#produto").change(function() {
            $("#categoria").val($(this).find(':selected').data('categoria'));
            $("#marca").val($(this).find(':selected').data('marca'));
        })
        $(".dinheiro").mask("###.###.##0,00", {
            reverse: true,
            maxlength: true
        });

        function adicionarProduto() {
            let produto = $("#produto").val();
            let serialnumber = $("#serialnumber").val();
            let valor = $("#valor").val().replace(/([^\d])+/g, '') / 100;
            let valorvenda = $("#valorvenda").val().replace(/([^\d])+/g, '') / 100;
            let quantidade = $("#quantidade").val();
            let compra = $("#compra").val();
            if (produto != '' && valor != '' && quantidade != '') {
                $.ajax({
                    data: {
                        produto: produto,
                        serialnumber: serialnumber,
                        valor: valor,
                        quantidade: quantidade,
                        compra: compra,
                        valorvenda: valorvenda
                    },
                    url: "/adicionarproduto/compra",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $("#tbodyproduto").append(data.view);
                        $('#valortotal').html(data.total);
                        $("#serialnumber").val('');
                        $("#valor").val('');
                        $("#valorvenda").val('');
                        $("#quantidade").val('');
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.responseText
                        });
                    }
                });
            } else {
                console.log("PREENCHA OS CAMPOS");
            }


        }

        function removerproduto(id, compra) {
            if (id != '') {
                $.ajax({
                    data: {
                        id: id,
                        compra: compra
                    },
                    url: "/removerproduto/compra",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $('#' + data.id).remove();
                        $('#valortotal').html(data.total);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.responseText
                        });
                    }
                });
            } else {
                console.log("PREENCHA OS CAMPOS");
            }
        }

        function adicionarquantidadeproduto(id, compra) {
            if (id != '') {
                $.ajax({
                    data: {
                        id: id,
                        compra: compra
                    },
                    url: "/adicionarquantidadeproduto/compra",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        $("#qtd" + id).text(data.quantidade);
                        $('#valortotal').html(data.total);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.responseText
                        });
                    }
                });
            } else {
                console.log("PREENCHA OS CAMPOS");
            }
        }

        function removerquantidadeproduto(id, compra) {
            if (id != '') {
                $.ajax({
                    data: {
                        id: id,
                        compra: compra
                    },
                    url: "/removerquantidadeproduto/compra",
                    type: "post",
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    },
                    success: function(data) {
                        if (data.quantidade <= 0) {
                            $('#' + id).remove();
                        } else {
                            $("#qtd" + id).text(data.quantidade);
                        }
                        $('#valortotal').html(data.total);
                    },
                    error: function(data) {
                        Swal.fire({
                            icon: 'error',
                            title: 'Oops...',
                            text: data.responseText
                        });
                    }
                });
            } else {
                console.log("PREENCHA OS CAMPOS");
            }
        }

        function finalizarcompra(compraid) {
            Swal.fire({
                title: 'Deseja finalizar a compra?',
                text: "Essa ação não é reversiva!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: 'Não',
                confirmButtonText: 'Sim, finalizar compra!'
            }).then((result) => {
                if (result.value) {
                    window.location.href = '/finalizar/compra/' + compraid;
                }
            })
        }

        $(document).ready(function() {
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
        });
    </script>


@stop
