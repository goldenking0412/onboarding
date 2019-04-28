<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Ticket;
use App\Models\Comment;
use Request;
use Illuminate\Http\Request as RequestNew;
use Illuminate\Support\Facades\Auth;
use Laravel\Spark\Contracts\Repositories\NotificationRepository;

class TicketsController extends Controller
{
	public function __construct(NotificationRepository $notifications)
	{
		$this->middleware('auth');
        $this->notifications = $notifications;
	}

   
    /**
     * Display all tickets.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $status = Request::get('status');
        if (!empty($status)):
        	$tickets = Ticket::with('lastComment')->latest()->where('status', $status)->paginate(10);
        else:
            $tickets = Ticket::with('lastComment')->latest()->paginate(10);
        endif;

        return view('tickets.index', compact('tickets'));
    }

    /**
     * Display all tickets by a user.
     *
     * @return \Illuminate\Http\Response
     */
    public function userTickets()
    {
        $tickets = Ticket::with('lastComment')->whereUserId(Auth::user()->id)->paginate(10);

        return view('tickets.user_tickets', compact('tickets'));
    }

    /**
     * Show the form for opening a new ticket.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $admin_user = User::where('type', 'admin')->firstOrFail();
        $this->notifications->create($admin_user, [
            'icon' => 'fa-tickets',
            'body' => 'A user opened a support request',
            'action_text' => 'Go To Conversations',
            'action_url' => '/admin/support',
        ]);
        return view('tickets.create');
    }

    /**
     * Store a newly created ticket in database.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(RequestNew $request)
    {
        $this->validate($request, [
            'title'     => 'required',
            'message'   => 'required'
        ]);

        $ticket = new Ticket([
            'title'     => $request->input('title'),
            'user_id'   => Auth::user()->id,
            'ticket_id' => strtoupper(str_random(10)),
            'message'   => $request->input('message'),
            'status'    => "Open",
        ]);

        $ticket->save();

        return redirect('/support')->with("status", "Success! Expect a response by the next business day.");
    }

    /**
     * Display a specified ticket.
     *
     * @param  int  $ticket_id
     * @return \Illuminate\Http\Response
     */
    public function show($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        // $comments = $ticket->comments;
        $comments =  $ticket->comments()->with('user')->get();
        // ->with('user')->get();
// dd($comments);
        return view('tickets.show', compact('ticket', 'comments'));
    }

    /**
     * Close the specified ticket.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function close($ticket_id)
    {
        $ticket = Ticket::where('ticket_id', $ticket_id)->firstOrFail();

        $ticket->status = 'Closed';

        $ticket->save();

        $ticketOwner = $ticket->user;

        // $mailer->sendTicketStatusNotification($ticketOwner, $ticket);

        return redirect()->back()->with("status", "The ticket has been closed.");
    }
}
