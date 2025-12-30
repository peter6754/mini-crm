<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('customer', 'media')->latest()->get();

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket->load('customer', 'media');

        return view('admin.tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $ticket->update(['status' => $request->status]);

        return redirect("/admin/tickets/{$ticket->id}")
            ->with('success', 'Статус обновлен');
    }
}
