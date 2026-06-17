@extends('layouts.app')
@section('title', 'Criar Conta')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h1 class="card-title text-2xl justify-center mb-4">Criar Conta</h1>

            <form action="{{ route('register') }}" method="POST" novalidate>
                @csrf

                {{-- Nome --}}
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text font-medium">Nome completo</span></label>
                    <input
                        type="text"
                        name="name"
                        value="{{ old('name') }}"
                        class="input input-bordered @error('name') input-error @enderror"
                        placeholder="Seu nome"
                    >
                    @error('name')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- E-mail --}}
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text font-medium">E-mail</span></label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="input input-bordered @error('email') input-error @enderror"
                        placeholder="seu@email.com"
                    >
                    @error('email')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Senha --}}
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text font-medium">Senha</span></label>
                    <input
                        type="password"
                        name="password"
                        class="input input-bordered @error('password') input-error @enderror"
                        placeholder="Mínimo 6 caracteres"
                    >
                    @error('password')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                {{-- Confirmar senha --}}
                <div class="form-control mb-3">
                    <label class="label"><span class="label-text font-medium">Confirmar senha</span></label>
                    <input
                        type="password"
                        name="password_confirmation"
                        class="input input-bordered"
                        placeholder="Repita a senha"
                    >
                </div>

                {{-- Perfil --}}
                <div class="form-control mb-6">
                    <label class="label"><span class="label-text font-medium">Perfil de acesso</span></label>
                    <div class="flex gap-6 mt-1">
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="role" value="participante" class="radio radio-primary"
                                {{ old('role', 'participante') === 'participante' ? 'checked' : '' }}>
                            <span>Participante</span>
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer">
                            <input type="radio" name="role" value="organizador" class="radio radio-primary"
                                {{ old('role') === 'organizador' ? 'checked' : '' }}>
                            <span>Organizador</span>
                        </label>
                    </div>
                    @error('role')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <button type="submit" class="btn btn-primary w-full">Criar conta</button>
            </form>

            <div class="divider">ou</div>
            <p class="text-center text-sm">
                Já tem conta? <a href="{{ route('login') }}" class="link link-primary">Entrar</a>
            </p>
        </div>
    </div>
</div>
@endsection
