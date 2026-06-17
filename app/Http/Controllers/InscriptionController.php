<?php

namespace App\Http\Controllers;

use App\Models\Event;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class InscriptionController extends Controller
{
    // RF10 - Histórico de inscrições do participante
    public function index()
    {
        $inscriptions = auth()->user()
                              ->inscriptions()
                              ->with('category')
                              ->latest('event_user.created_at')
                              ->paginate(10);

        return view('participant.inscriptions', compact('inscriptions'));
    }

    // RF08 + RF09 - Inscrição e geração do passaporte
    public function store(Event $event)
    {
        $user = auth()->user();

        // RN04 - Unicidade de inscrição
        if ($user->inscriptions()->where('event_id', $event->id)->exists()) {
            return back()->with('error', 'Você já está inscrito neste evento.');
        }

        // RN05 - Limite de capacidade
        if ($event->isFull()) {
            return back()->with('error', 'Vagas esgotadas! Não há mais vagas disponíveis para este evento.');
        }

        // RF09 - Gera ticket_code alfanumérico único
        $ticketCode = strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4)) . '-' . strtoupper(Str::random(4));

        $user->inscriptions()->attach($event->id, [
            'ticket_code' => $ticketCode,
            'status'      => 'confirmada',
        ]);

        return back()->with('success', "Inscrição realizada! Seu passaporte é: {$ticketCode}");
    }

    // RF11 - Cancelamento de inscrição
    public function destroy(Event $event)
    {
        $user = auth()->user();

        if (!$user->inscriptions()->where('event_id', $event->id)->exists()) {
            return back()->with('error', 'Você não está inscrito neste evento.');
        }

        $user->inscriptions()->detach($event->id);

        return back()->with('success', 'Inscrição cancelada com sucesso. Sua vaga foi liberada.');
    }
}
