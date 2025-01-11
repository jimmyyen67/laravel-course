<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Option;
use App\Models\Poll;

class Polls extends Component
{
    protected $listeners = [
        'pollCreated' => 'render',
    ];

    public function render()
    {
        $polls = Poll::with('options.votes')->latest()->get();
        return view('livewire.polls', ['polls' => $polls]);
    }

    /**
     * @param integer $optionId
     * @return void
     */
    public function vote(Option $option)
    {
        $option->votes()->create();
    }
}
