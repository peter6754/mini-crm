<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\Ticket;
use Illuminate\Database\Eloquent\Builder;

class TicketService
{
    public function getFilteredTickets(array $filters)
    {
        $query = Ticket::with('customer', 'media');

        if (! empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        if (! empty($filters['phone'])) {
            $query->whereHas('customer', function (Builder $q) use ($filters) {
                $q->where('phone', 'like', '%'.$filters['phone'].'%');
            });
        }

        if (! empty($filters['email'])) {
            $query->whereHas('customer', function (Builder $q) use ($filters) {
                $q->where('email', 'like', '%'.$filters['email'].'%');
            });
        }

        if (! empty($filters['date_from'])) {
            $query->whereDate('created_at', '>=', $filters['date_from']);
        }

        if (! empty($filters['date_to'])) {
            $query->whereDate('created_at', '<=', $filters['date_to']);
        }

        return $query->latest()->get();
    }

    public function getTicketById(int $id): Ticket
    {
        return Ticket::with('customer', 'media')->findOrFail($id);
    }

    public function updateTicketStatus(Ticket $ticket, string $status): bool
    {
        return $ticket->update(['status' => $status]);
    }

    public function createTicket(array $data, $attachments = null): Ticket
    {
        $customer = Customer::firstOrCreate(
            ['phone' => $data['phone']],
            [
                'name' => $data['name'],
                'email' => $data['email'] ?? null,
            ]
        );

        $ticket = $customer->tickets()->create([
            'theme' => $data['theme'],
            'text' => $data['text'],
            'status' => $data['status'] ?? 'new',
        ]);

        if ($attachments) {
            foreach ($attachments as $file) {
                $ticket->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return $ticket->load('customer', 'media');
    }
}
