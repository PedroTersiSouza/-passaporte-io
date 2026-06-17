{{--
    Partial reutilizável para o formulário de criação e edição de eventos.
    Variável $event é opcional (null em create, populada em edit).
--}}

{{-- Título --}}
<div class="form-control mb-4">
    <label class="label"><span class="label-text font-medium">Título do evento</span></label>
    <input
        type="text"
        name="title"
        value="{{ old('title', $event->title ?? '') }}"
        class="input input-bordered @error('title') input-error @enderror"
        placeholder="Mínimo 5 caracteres"
    >
    @error('title')
        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>

{{-- Descrição --}}
<div class="form-control mb-4">
    <label class="label"><span class="label-text font-medium">Descrição</span></label>
    <textarea
        name="description"
        rows="4"
        class="textarea textarea-bordered @error('description') textarea-error @enderror"
        placeholder="Descreva o evento..."
    >{{ old('description', $event->description ?? '') }}</textarea>
    @error('description')
        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>

{{-- Data e Hora --}}
<div class="form-control mb-4">
    <label class="label"><span class="label-text font-medium">Data e Hora</span></label>
    <input
        type="datetime-local"
        name="date_time"
        value="{{ old('date_time', isset($event) ? $event->date_time->format('Y-m-d\TH:i') : '') }}"
        class="input input-bordered @error('date_time') input-error @enderror"
        min="{{ now()->format('Y-m-d\TH:i') }}"
    >
    @error('date_time')
        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>

{{-- Localização --}}
<div class="form-control mb-4">
    <label class="label"><span class="label-text font-medium">Localização</span></label>
    <input
        type="text"
        name="location"
        value="{{ old('location', $event->location ?? '') }}"
        class="input input-bordered @error('location') input-error @enderror"
        placeholder="Endereço ou nome do local"
    >
    @error('location')
        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>

{{-- Capacidade + Categoria --}}
<div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mb-4">
    <div class="form-control">
        <label class="label"><span class="label-text font-medium">Capacidade (vagas)</span></label>
        <input
            type="number"
            name="capacity"
            value="{{ old('capacity', $event->capacity ?? '') }}"
            class="input input-bordered @error('capacity') input-error @enderror"
            min="1"
            placeholder="Ex: 100"
        >
        @error('capacity')
            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
        @enderror
    </div>

    <div class="form-control">
        <label class="label"><span class="label-text font-medium">Categoria</span></label>
        <select name="category_id" class="select select-bordered @error('category_id') select-error @enderror">
            <option value="">Selecione...</option>
            @foreach($categories as $category)
                <option value="{{ $category->id }}"
                    {{ old('category_id', $event->category_id ?? '') == $category->id ? 'selected' : '' }}>
                    {{ $category->name }}
                </option>
            @endforeach
        </select>
        @error('category_id')
            <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
        @enderror
    </div>
</div>

{{-- Banner --}}
<div class="form-control mb-6">
    <label class="label">
        <span class="label-text font-medium">Banner de capa</span>
        <span class="label-text-alt text-base-content/60">Máx. 2MB — JPG, PNG, GIF, WEBP</span>
    </label>

    @isset($event)
        <div class="mb-2">
            <p class="text-sm text-base-content/60 mb-1">Banner atual:</p>
            <img src="{{ Storage::url($event->banner_path) }}" alt="Banner atual" class="h-32 rounded object-cover">
            <p class="text-xs text-base-content/40 mt-1">Envie uma nova imagem para substituir.</p>
        </div>
    @endisset

    <input
        type="file"
        name="banner"
        accept="image/*"
        class="file-input file-input-bordered w-full @error('banner') file-input-error @enderror"
    >
    @error('banner')
        <label class="label"><span class="label-text-alt text-error">{{ $message }}</span></label>
    @enderror
</div>
