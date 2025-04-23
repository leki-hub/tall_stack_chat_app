<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Message;
use Illuminate\Support\Facades\Auth;

class Chat extends Component
{
    public $message;

    protected $rules = [
        'message' => 'required|string|max:1000',
    ];

    public function sendMessage()
    {
        $this->validate();

        $msg = Message::create([
            'user_id' => Auth::id(),
            'body' => $this->message,
        ]);

        $this->dispatch('message-sent', $msg->id);

        $this->message = '';
    }

    public function triggerTyping()
    {
        $this->dispatch('user-typing', auth()->user()->name);
    }



    public function render()
    {
        return view('livewire.chat', [
            'messages' => Message::with('user')->latest()->take(20)->get()->reverse(),
        ]);
    }
}
