@extends('layouts.app')
@section('title', $event->title)

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="card bg-base-100 shadow-xl">

        {{-- Banner --}}
        <figure>
            <img
                src="{{ Storage::url($event->banner_path) }}"
                alt="Banner de {{ $event->title }}"
                class="w-full max-h-80 object-cover"
            >
        </figure>

        <div class="card-body gap-4">

            {{-- Badge + Título --}}
            <div>
                <div class="badge badge-primary badge-outline mb-2">{{ $event->category->name }}</div>
                <h1 class="text-3xl font-bold">{{ $event->title }}</h1>
            </div>

            {{-- Infos --}}
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 text-sm">
                <div class="flex items-center gap-2">
                    <span class="text-xl">📅</span>
                    <div>
                        <p class="font-medium">Data e Hora</p>
                        <p class="text-base-content/70">{{ $event->date_time->format('d/m/Y \à\s H:i') }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">📍</span>
                    <div>
                        <p class="font-medium">Local</p>
                        <p class="text-base-content/70">{{ $event->location }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">👤</span>
                    <div>
                        <p class="font-medium">Organizador</p>
                        <p class="text-base-content/70">{{ $event->organizer->name }}</p>
                    </div>
                </div>
                <div class="flex items-center gap-2">
                    <span class="text-xl">🎟</span>
                    <div>
                        <p class="font-medium">Vagas</p>
                        <p class="{{ $event->isFull() ? 'text-error font-semibold' : 'text-success' }}">
                            {{ $event->isFull() ? 'Esgotado' : $event->spotsLeft() . ' de ' . $event->capacity . ' disponíveis' }}
                        </p>
                    </div>
                </div>
            </div>

            <div class="divider"></div>

            {{-- Descrição --}}
            <div>
                <h2 class="text-lg font-semibold mb-2">Sobre o evento</h2>
                <p class="text-base-content/80 leading-relaxed">{{ $event->description }}</p>
            </div>

            <div class="divider"></div>

            {{-- Ação de inscrição --}}
            <div class="card-actions justify-between items-center">
                <a href="{{ route('home') }}" class="btn btn-ghost btn-sm">← Voltar</a>

                @guest
                    <a href="{{ route('login') }}" class="btn btn-primary">
                        Entre para se inscrever
                    </a>
                @endguest

                @auth
                    @if(auth()->user()->isParticipante())
                        @php
                            $inscrito = auth()->user()->inscriptions->contains($event->id);
                        @endphp

                        @if($inscrito)
                            <div class="flex flex-col items-end gap-2">
                                <div class="badge badge-success gap-1 p-3">
                                    ✅ Você está inscrito
                                </div>
                                <form action="{{ route('participant.inscriptions.destroy', $event) }}" method="POST"
                                      onsubmit="return confirm('Deseja cancelar sua inscrição neste evento?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-error btn-sm btn-outline">
                                        Cancelar inscrição
                                    </button>
                                </form>
                            </div>
                        @elseif($event->isFull())
                            <button class="btn btn-disabled" disabled>Vagas esgotadas</button>
                        @else
                            <form action="{{ route('participant.inscriptions.store', $event) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-primary">
                                    🎫 Inscrever-se
                                </button>
                            </form>
                        @endif
                    @endif

                    @if(auth()->user()->isOrganizador())
                        <div class="alert alert-info py-2 px-4 text-sm">
                            Organizadores não podem se inscrever em eventos.
                        </div>
                    @endif
                @endauth
            </div>

        </div>
    </div>
</div>
@endsection
