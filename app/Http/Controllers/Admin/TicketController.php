<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use App\Services\TicketService;
use Illuminate\Http\Request;

class TicketController extends Controller
{
    protected TicketService $ticketService;

    public function __construct(TicketService $ticketService)
    {
        $this->ticketService = $ticketService;
    }

    public function index(Request $request)
    {
        $filters = [
            'status' => $request->input('status'),
            'phone' => $request->input('phone'),
            'email' => $request->input('email'),
            'date_from' => $request->input('date_from'),
            'date_to' => $request->input('date_to'),
        ];

        $tickets = $this->ticketService->getFilteredTickets($filters);

        return view('admin.tickets.index', compact('tickets'));
    }

    public function show(Ticket $ticket)
    {
        $ticket = $this->ticketService->getTicketById($ticket->id);

        return view('admin.tickets.show', compact('ticket'));
    }

    public function update(Request $request, Ticket $ticket)
    {
        $this->ticketService->updateTicketStatus($ticket, $request->status);

        return redirect("/admin/tickets/{$ticket->id}")
            ->with('success', 'Статус обновлен');
    }
}
