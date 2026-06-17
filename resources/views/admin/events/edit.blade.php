@extends('layouts.app')
@section('title', 'Editar Evento')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h1 class="card-title text-2xl">Editar Evento</h1>
                <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm">← Voltar</a>
            </div>

            <form action="{{ route('admin.events.update', $event) }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @method('PUT')
                @include('admin.events._form')
                <button type="submit" class="btn btn-primary w-full">Salvar Alterações</button>
            </form>
        </div>
    </div>
</div>
@endsection
