<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ticket;
use Illuminate\Http\Request;

class AdminController extends Controller
{
    public function index()
    {
        $tickets = Ticket::with('customer', 'media')->latest()->get();

        return view('admin.tickets.index', compact('tickets'));
    }
}
