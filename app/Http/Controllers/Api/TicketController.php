<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTicketRequest;
use App\Http\Resources\TicketResource;
use App\Models\Customer;
use Illuminate\Http\JsonResponse;

class TicketController extends Controller
{
    public function store(StoreTicketRequest $request): JsonResponse
    {
        $validated = $request->validated();

        $customer = Customer::firstOrCreate(
            ['phone' => $validated['phone'],
                'name' => $validated['name'],
                'email' => $validated['email'],
            ]
        );

        $ticket = $customer->tickets()->create([
            'theme' => $validated['theme'],
            'text' => $validated['text'],
        ]);

        if ($request->hasFile('attachments')) {
            foreach ($request->file('attachments') as $file) {
                $ticket->addMedia($file)->toMediaCollection('attachments');
            }
        }

        return new TicketResource($ticket)->response()->setStatusCode(201);
    }
}
