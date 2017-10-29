<?php
/**
 * Created by PhpStorm.
 * User: omar
 * Date: 10/26/17
 * Time: 2:21 PM
 */

namespace App\Http\Controllers;


use App\Ticket;

class TicketPrintController extends Controller
{
    function show(Ticket $ticket)
    {
        return view('ticket.print', compact('ticket'));
    }
}