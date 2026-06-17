<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Event;
use Illuminate\Http\Request;

class PublicEventController extends Controller
{
    // RF12 + RF13 - Vitrine com filtragem por categoria
    // RNF04 - Eager loading para mitigar N+1
    public function index(Request $request)
    {
        $categories = Category::orderBy('name')->get();

        $query = Event::with(['organizer', 'category'])
                      ->orderBy('date_time');

        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        $events = $query->paginate(12);

        return view('public.events.index', compact('events', 'categories'));
    }

    // RF14 - Detalhes do evento
    public function show(Event $event)
    {
        $event->load(['organizer', 'category', 'participants']);

        return view('public.events.show', compact('event'));
    }
}
