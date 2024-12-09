<?php

namespace App\Http\Controllers;

use App\Models\Conversation;
use App\Models\Message;
use Illuminate\Http\Request;

class MessagesController extends Controller
{
    public function index()
    {
        $conversations = array();
        
        if (auth()->user()->isClient()) {
            $conversations = Conversation::with('report:id,audit_report_title')->where('lead_body_id', auth()->user()->lead_body_id)->get();
        } elseif (auth()->user()->isStakeholder()) {
            $conversations = Conversation::with('report:id,audit_report_title')->where('stakeholder_id', auth()->user()->stakeholder_id)->get();
        }

        return view('messages', compact(
            'conversations'
        ));
    }

    public function show(Conversation $conversation)
    {
        $messages_are_loaded = true;


        $conversation->load('messages');

        if (auth()->user()->isClient()) {
            $conversations = Conversation::with('report:id,audit_report_title')->where('lead_body_id', auth()->user()->lead_body_id)->get();
        } elseif (auth()->user()->isStakeholder()) {
            $conversations = Conversation::with('report:id,audit_report_title')->where('stakeholder_id', auth()->user()->stakeholder_id)->get();
        }

        return view('message_details', compact('conversation', 'conversations', 'messages_are_loaded'));
    }

    public function store(Request $request)
    {
        $this->validate($request, [
            'content' => 'required'
        ]);

        $convasation = Conversation::create([
            'lead_body_id' => $request->{'client_id'},
            'final_report_id' => $request->{'final_report_id'},
            'stakeholder_id' => auth()->user()->stakeholder_id,
        ]);

        Message::create([
            'content' => $request->{'content'},
            'conversation_id' => $convasation->id,
            'sender_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Message Sent!');
    }

    public function reply(Request $request)
    {
        $this->validate($request, [
            'content' => 'required|max:2000',
        ]);

        Message::create([
            'content' => $request->{'content'},
            'conversation_id' => $request->{'conversation_id'},
            'sender_id' => auth()->user()->id,
        ]);

        return redirect()->back()->with('success', 'Reply Sent' );
    }

    public function getModel()
    {
        return new Message();
    }
}
