@extends('layouts.app')
@section('title', 'Entrar')

@section('content')
<div class="max-w-md mx-auto">
    <div class="card bg-base-100 shadow-xl">
        <div class="card-body">
            <h1 class="card-title text-2xl justify-center mb-4">Entrar na plataforma</h1>

            <form action="{{ route('login') }}" method="POST" novalidate>
                @csrf

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text font-medium">E-mail</span></label>
                    <input
                        type="email"
                        name="email"
                        value="{{ old('email') }}"
                        class="input input-bordered @error('email') input-error @enderror"
                        placeholder="seu@email.com"
                        autofocus
                    >
                    @error('email')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control mb-3">
                    <label class="label"><span class="label-text font-medium">Senha</span></label>
                    <input
                        type="password"
                        name="password"
                        class="input input-bordered @error('password') input-error @enderror"
                        placeholder="Sua senha"
                    >
                    @error('password')
                        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
                    @enderror
                </div>

                <div class="form-control mb-6">
                    <label class="label cursor-pointer justify-start gap-3">
                        <input type="checkbox" name="remember" class="checkbox checkbox-primary checkbox-sm">
                        <span class="label-text">Lembrar de mim</span>
                    </label>
                </div>

                <button type="submit" class="btn btn-primary w-full">Entrar</button>
            </form>

            <div class="divider">ou</div>
            <p class="text-center text-sm">
                Não tem conta? <a href="{{ route('register') }}" class="link link-primary">Criar conta</a>
            </p>
        </div>
    </div>
</div>
@endsection
