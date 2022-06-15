@extends('adminlte::page')


@section('title', 'Adicionar Novo Usuario')


@section('content_header')
    <div class="row">
        <div class="col-12">
            <ol class="breadcrumb">
                <li class="breadcrumb-item "><a href="/">Home</a></li>
                <li class="breadcrumb-item active">Master</li>
                <li class="breadcrumb-item"><a href="/categoria/">Usuario</a></li>
                <li class="breadcrumb-item active">Novo Usuario</li>
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
                    <h3 class="card-title">Preencha os campos</h3>
                </div>
                <form action="/usuario/nova" method="POST">
                    @csrf
                    <div class="card-body">
                        <div class="form-group">
                            <label for="nome">Nome</label>
                            <input type="text" class="form-control" id="nome" name="nome"
                                placeholder="Digite o nome do usuario" value="{{ old('nome') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="email">Email</label>
                            <input type="text" class="form-control" id="email" name="email"
                                placeholder="Digite o email do usuario" value="{{ old('email') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="password">Senha</label>
                            <input type="password" class="form-control" id="password" name="password"
                                placeholder="Digite a senha do usuario" value="{{ old('password') }}" required autofocus>
                        </div>
                        <div class="form-group">
                            <label for="empresaid">Empresa ID</label>
                            <input type="text" class="form-control" id="empresaid" name="empresaid"
                                placeholder="Digite a Empresa ID do usuario" value="{{ old('empresaid') }}" required
                                autofocus>
                        </div>
                        <div class="form-group">
                            <label for="nivel_acesso">Nivel de Acesso</label>
                            <input type="text" class="form-control" id="nivel_acesso" name="nivel_acesso"
                                placeholder="Digite o Nivel de Acesso do usuario" value="{{ old('nivel_acesso') }}"
                                required autofocus>
                        </div>
                    </div>
                    <div class="card-footer">
                        <button type="submit" class="btn btn-primary float-right">Cadastrar</button>
                        <a href="/usuario" class="btn btn-danger" tabindex="-1" role="button"
                            aria-disabled="true">Cancelar</a>
                    </div>
                </form>
            </div>
        </div>
    </div>
@stop

@section('css')
    <link rel="stylesheet" href="/css/admin_custom.css">
@stop

@section('js')
    <script></script>
@stop
