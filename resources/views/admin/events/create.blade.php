@extends('layouts.app')
@section('title', 'Criar Evento')

@section('content')
<div class="max-w-2xl mx-auto">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <div class="flex items-center justify-between mb-4">
                <h1 class="card-title text-2xl">Novo Evento</h1>
                <a href="{{ route('admin.events.index') }}" class="btn btn-ghost btn-sm">← Voltar</a>
            </div>

            <form action="{{ route('admin.events.store') }}" method="POST" enctype="multipart/form-data" novalidate>
                @csrf
                @include('admin.events._form')
                <button type="submit" class="btn btn-primary w-full">Criar Evento</button>
            </form>
        </div>
    </div>
</div>
@endsection
