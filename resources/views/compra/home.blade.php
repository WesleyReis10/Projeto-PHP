@extends('adminlte::page')


@section('title', 'Empresa')

@section('content_header')
    <div class="row">
        <div class="col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Gerenciamento</li>
                <li class="breadcrumb-item active">Empresa</li>
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
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <div class="col-lg-3">
                        <div class="small-box bg-success">
                            <div class="inner">
                                <h3>Criar</h3>
                                <p>Compra</p>
                            </div>
                            <div class="icon">
                                <i class="fas fa-dice-d6"></i>
                            </div>
                            <a href="/compra/nova" class="small-box-footer">Clique aqui <i
                                    class="fas fa-arrow-circle-right"></i></a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-12">
            <div class="card">
                <div class="card-body">
                    <table class="table table-striped" id="tabelaempresa">
                        <thead>
                            <tr>
                                <td class="ocultarmobile">ID</td>
                                <td>descricao</td>
                                <td>status</td>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($compras as $compra)
                                <tr>
                                    <td class="ocultarmobile">{{ $compra->id }}</td>
                                    <td>{{ $compra->descricao }}</td>
                                    <td>{{ $compra->status }}</td>
                                    <td style="text-align: right; width: 25%;">
                                        @if($compra->status == "Aberta")
                                        <a href="{{ route('compracarrinho', $compra->id) }}"
                                            class="btn btn-primary">Adicionar Produtos</a>
                                        @else
                                        <a href="{{ route('relatoriocompra', $compra->id) }}"
                                            class="btn btn-warning text-white">Verificar</a>
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>


    <form action="/empresa/deletar/" method="POST">
        @csrf
        @method('DELETE')
        <div class="modal fade" id="deleteModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel"
            aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="exampleModalLabel">Confirmação</h5>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                    <div class="modal-body">
                        Realmente gostaria de deletar?
                    </div>
                    <input type="hidden" name="empresa_id" id="empresa_id" value="">
                    <div class="modal-footer">
                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Fechar</button>
                        <button class="btn btn-danger" type="submit">Confirmar</button>
                    </div>
                </div>
            </div>
        </div>
    </form>





@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
    <style>
        @media (max-width : 500px) {
            .ocultarmobile {
                display: none;
            }
        }

    </style>
@stop

@section('js')
    <script>
        $(document).ready(function() {
            $("#tabelaempresa").DataTable({
                "order": [],
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

    <script>
        $('#deleteModal').on('show.bs.modal', function(event) {
            var button = $(event.relatedTarget) // Button that triggered the modal
            var recipientId = button.data('id') // Extract info from data-* attributes
            // If necessary, you could initiate an AJAX request here (and then do the updating in a callback).
            // Update the modal's content. We'll use jQuery here, but you could use a data binding library or other methods instead.
            console.log(recipientId);
            var modal = $(this);
            modal.find('#empresa_id').val(recipientId);
        })
    </script>
@stop
