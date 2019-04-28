<?php

namespace App\Http\Controllers;

use App\User;
use App\Models\Ticket;
use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Mail\SendMailable;
use Illuminate\Support\Facades\Mail;


class CommentsController extends Controller
{
	/**
	 * Persist comment and mail user
	 * @param  Request  $request
	 * @param  AppMailer $mailer
	 * @return Response
	 */
    public function postComment(Request $request)
    {
    	$this->validate($request, [
            'comment'   => 'required'
        ]);

        $comment =  new Comment([
        	'ticket_id' => $request->input('ticket_id'),
        	'user_id'	=> Auth::user()->id,
        	'comment'	=> $request->input('comment'),
        ]);

        // $ticket = Ticket::where('id', $request->input('ticket_id'));
        // $ticket->touch();

        $comment->save();

        // send mail if the user commenting is not the ticket owner
        if ($comment->ticket->user->id !== Auth::user()->id) {
            $ticket_owner = User::find($comment->ticket->user_id);
            Mail::to($ticket_owner)->send(new SendMailable($comment));
        }
        
        return redirect()->back()->with("status", "Your comment has be submitted.");
    }
}
