@extends('layouts.app')
@section('title', 'Eventos')

@section('content')
<div class="flex flex-col gap-6">

    {{-- Cabeçalho --}}
    <div class="text-center py-8">
        <h1 class="text-4xl font-bold text-primary mb-2">Descubra Eventos</h1>
        <p class="text-base-content/70">Encontre os melhores eventos perto de você</p>
    </div>

    {{-- Filtro por categorias --}}
    <div class="flex flex-wrap gap-2 justify-center">
        <a href="{{ route('home') }}"
           class="btn btn-sm {{ !request('category') ? 'btn-primary' : 'btn-ghost' }}">
            Todos
        </a>
        @foreach($categories as $category)
            <a href="{{ route('home', ['category' => $category->id]) }}"
               class="btn btn-sm {{ request('category') == $category->id ? 'btn-primary' : 'btn-ghost' }}">
                {{ $category->name }}
            </a>
        @endforeach
    </div>

    {{-- Grid de eventos --}}
    @if($events->isEmpty())
        <div class="alert alert-info max-w-lg mx-auto">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Nenhum evento encontrado para esta categoria.</span>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($events as $event)
                <div class="card bg-base-100 shadow-md hover:shadow-xl transition-shadow">
                    <figure class="h-48 overflow-hidden">
                        <img
                            src="{{ Storage::url($event->banner_path) }}"
                            alt="Banner de {{ $event->title }}"
                            class="w-full h-full object-cover"
                        >
                    </figure>
                    <div class="card-body">
                        <div class="badge badge-primary badge-outline text-xs">{{ $event->category->name }}</div>
                        <h2 class="card-title text-lg">{{ $event->title }}</h2>
                        <div class="text-sm text-base-content/70 space-y-1">
                            <p>📅 {{ $event->date_time->format('d/m/Y \à\s H:i') }}</p>
                            <p>📍 {{ $event->location }}</p>
                            <p>👤 {{ $event->organizer->name }}</p>
                            <p class="{{ $event->isFull() ? 'text-error font-semibold' : 'text-success' }}">
                                🎟 {{ $event->isFull() ? 'Vagas esgotadas' : $event->spotsLeft() . ' vagas restantes' }}
                            </p>
                        </div>
                        <div class="card-actions justify-end mt-2">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-primary btn-sm">
                                Ver detalhes
                            </a>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        {{-- Paginação --}}
        <div class="flex justify-center mt-4">
            {{ $events->links() }}
        </div>
    @endif
</div>
@endsection
