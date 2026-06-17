<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class AdminEventController extends Controller
{
    // RF04 - Listagem dos eventos do organizador
    public function index()
    {
        $events = auth()->user()
                        ->events()
                        ->with('category')
                        ->latest()
                        ->paginate(10);

        return view('admin.events.index', compact('events'));
    }

    // RF05 - Formulário de criação
    public function create()
    {
        $categories = Category::orderBy('name')->get();
        return view('admin.events.create', compact('categories'));
    }

    // RF05 - Persistência do evento
    public function store(Request $request)
    {
        $data = $this->validateEvent($request);

        // RNF09 - Ofusca nome do arquivo
        $path = $request->file('banner')->storeAs(
            'banners',
            Str::uuid() . '.' . $request->file('banner')->extension(),
            'public'
        );

        // RN07 - user_id vem do auth, não do formulário
        auth()->user()->events()->create([
            'category_id' => $data['category_id'],
            'title'       => $data['title'],
            'description' => $data['description'],
            'date_time'   => $data['date_time'],
            'location'    => $data['location'],
            'capacity'    => $data['capacity'],
            'banner_path' => $path,
        ]);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Evento criado com sucesso!');
    }

    // RF06 - Formulário de edição
    public function edit(Event $event)
    {
        // RN09 - Só o dono pode editar
        $this->authorizeOwner($event);

        $categories = Category::orderBy('name')->get();
        return view('admin.events.edit', compact('event', 'categories'));
    }

    // RF06 - Atualização do evento
    public function update(Request $request, Event $event)
    {
        $this->authorizeOwner($event);

        $data = $this->validateEvent($request, isUpdate: true);

        if ($request->hasFile('banner')) {
            // Remove banner antigo
            Storage::disk('public')->delete($event->banner_path);

            // RNF09 - Ofusca nome do novo arquivo
            $data['banner_path'] = $request->file('banner')->storeAs(
                'banners',
                Str::uuid() . '.' . $request->file('banner')->extension(),
                'public'
            );
        }

        $event->update($data);

        return redirect()->route('admin.events.index')
                         ->with('success', 'Evento atualizado com sucesso!');
    }

    // RF07 - Exclusão do evento
    public function destroy(Event $event)
    {
        $this->authorizeOwner($event);

        // RN03 - Bloqueia exclusão se tiver inscritos
        if ($event->participants()->count() > 0) {
            return back()->with('error', 'Não é possível excluir um evento com participantes inscritos. Cancele as inscrições antes ou entre em contato com o suporte.');
        }

        Storage::disk('public')->delete($event->banner_path);
        $event->delete();

        return redirect()->route('admin.events.index')
                         ->with('success', 'Evento excluído com sucesso!');
    }

    // ─── Helpers privados ────────────────────────────────────────────────────

    private function authorizeOwner(Event $event): void
    {
        if ($event->user_id !== auth()->id()) {
            abort(403, 'Você não tem permissão para modificar este evento.');
        }
    }

    private function validateEvent(Request $request, bool $isUpdate = false): array
    {
        $bannerRules = $isUpdate
            ? ['nullable', 'image', 'max:2048']
            : ['required', 'image', 'max:2048'];

        return $request->validate([
            'title'       => ['required', 'string', 'min:5', 'max:255'],
            'description' => ['required', 'string', 'min:10'],
            'date_time'   => ['required', 'date', 'after:now'],
            'location'    => ['required', 'string', 'max:255'],
            'capacity'    => ['required', 'integer', 'min:1'],
            'category_id' => ['required', 'exists:categories,id'],
            'banner'      => $bannerRules,
        ], [
            'title.required'       => 'O título é obrigatório.',
            'title.min'            => 'O título deve ter ao menos 5 caracteres.',
            'description.required' => 'A descrição é obrigatória.',
            'description.min'      => 'A descrição deve ter ao menos 10 caracteres.',
            'date_time.required'   => 'A data e hora são obrigatórias.',
            'date_time.after'      => 'A data do evento deve ser futura. Não é possível cadastrar eventos com datas retroativas.',
            'location.required'    => 'A localização é obrigatória.',
            'capacity.required'    => 'A capacidade é obrigatória.',
            'capacity.min'         => 'A capacidade deve ser de ao menos 1 vaga.',
            'category_id.required' => 'Selecione uma categoria.',
            'category_id.exists'   => 'Categoria inválida.',
            'banner.required'      => 'O banner de capa é obrigatório.',
            'banner.image'         => 'O banner deve ser uma imagem válida (jpg, png, gif, etc).',
            'banner.max'           => 'O banner não pode ultrapassar 2MB.',
        ]);
    }
}
