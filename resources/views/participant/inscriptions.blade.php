@extends('layouts.app')
@section('title', 'Meus Ingressos')

@section('content')
<div class="flex flex-col gap-6">

    <h1 class="text-2xl font-bold">Meus Ingressos</h1>

    @if($inscriptions->isEmpty())
        <div class="alert alert-info">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" class="h-6 w-6 shrink-0 stroke-current">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 16h-1v-4h-1m1-4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/>
            </svg>
            <span>Você ainda não se inscreveu em nenhum evento.
                <a href="{{ route('home') }}" class="link">Explorar eventos</a>
            </span>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            @foreach($inscriptions as $event)
                <div class="card bg-base-100 shadow border border-base-200">
                    <div class="card-body">
                        <div class="flex items-start justify-between">
                            <div>
                                <div class="badge badge-primary badge-outline text-xs mb-1">{{ $event->category->name }}</div>
                                <h2 class="font-bold text-lg">{{ $event->title }}</h2>
                                <p class="text-sm text-base-content/70">📅 {{ $event->date_time->format('d/m/Y \à\s H:i') }}</p>
                                <p class="text-sm text-base-content/70">📍 {{ $event->location }}</p>
                            </div>
                        </div>

                        <div class="divider my-2"></div>

                        {{-- Passaporte --}}
                        <div class="bg-base-200 rounded-lg p-3 text-center">
                            <p class="text-xs text-base-content/60 mb-1">Código do Passaporte</p>
                            <p class="font-mono font-bold text-lg tracking-widest text-primary">
                                {{ $event->pivot->ticket_code }}
                            </p>
                            <div class="badge badge-success badge-sm mt-1">{{ $event->pivot->status }}</div>
                        </div>

                        <div class="card-actions justify-between items-center mt-2">
                            <a href="{{ route('events.show', $event) }}" class="btn btn-ghost btn-xs">Ver evento</a>
                            <form action="{{ route('participant.inscriptions.destroy', $event) }}" method="POST"
                                  onsubmit="return confirm('Deseja cancelar sua inscrição em \'{{ addslashes($event->title) }}\'?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-error btn-xs btn-outline">Cancelar inscrição</button>
                            </form>
                        </div>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="flex justify-center">
            {{ $inscriptions->links() }}
        </div>
    @endif
</div>
@endsection
