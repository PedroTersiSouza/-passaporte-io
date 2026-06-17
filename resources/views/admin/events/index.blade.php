@extends('layouts.app')
@section('title', 'Painel — Meus Eventos')

@section('content')
<div class="flex flex-col gap-6">

    <div class="flex items-center justify-between">
        <h1 class="text-2xl font-bold">Meus Eventos</h1>
        <a href="{{ route('admin.events.create') }}" class="btn btn-primary btn-sm">
            + Novo Evento
        </a>
    </div>

    @if($events->isEmpty())
        <div class="alert alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Você ainda não criou nenhum evento. <a href="{{ route('admin.events.create') }}" class="link">Crie o primeiro!</a></span>
        </div>
    @else
        <div class="overflow-x-auto">
            <table class="table table-zebra bg-base-100 shadow rounded-xl">
                <thead>
                    <tr>
                        <th>Evento</th>
                        <th>Categoria</th>
                        <th>Data</th>
                        <th>Vagas</th>
                        <th>Inscritos</th>
                        <th class="text-right">Ações</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($events as $event)
                        <tr>
                            <td class="font-medium">{{ $event->title }}</td>
                            <td><div class="badge badge-outline">{{ $event->category->name }}</div></td>
                            <td>{{ $event->date_time->format('d/m/Y H:i') }}</td>
                            <td>{{ $event->capacity }}</td>
                            <td>
                                <span class="{{ $event->isFull() ? 'text-error font-bold' : '' }}">
                                    {{ $event->participants()->count() }}
                                </span>
                            </td>
                            <td class="text-right">
                                <div class="flex justify-end gap-2">
                                    <a href="{{ route('events.show', $event) }}" class="btn btn-ghost btn-xs">
                                        👁 Ver
                                    </a>
                                    <a href="{{ route('admin.events.edit', $event) }}" class="btn btn-info btn-xs">
                                        ✏️ Editar
                                    </a>
                                    <form action="{{ route('admin.events.destroy', $event) }}" method="POST"
                                          onsubmit="return confirm('Tem certeza que deseja excluir o evento \'{{ addslashes($event->title) }}\'? Esta ação não pode ser desfeita.')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn btn-error btn-xs">🗑 Excluir</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>

        <div class="flex justify-center">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection
