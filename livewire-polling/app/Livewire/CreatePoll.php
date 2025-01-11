<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;
use App\Models\Poll;

class CreatePoll extends Component
{
    public string $title;
    public array $options = ['']; // need first empty option for user to input

    /**
     * @return Factory|View|Application|\Illuminate\Contracts\Foundation\Application
     */
    public function render()
    {
        return view('livewire.create-poll');
    }

    /**
     * @return void
     */
    public function addOption(): void
    {
        $this->options[] = '';
    }

    /**
     * @param int $index
     * @return void
     */
    public function removeOption(int $index): void
    {
        unset($this->options[$index]);
        $this->options = array_values($this->options); // re-index the array
    }

    public function createPoll()
    {
        $poll = Poll::create([
            'title' => $this->title,
        ]);

        foreach($this->options as $optionName) {
            $poll->options()->create([
                'name' => $optionName,
            ]);
        }

        $this->reset(['title', 'options']);
    }

    // public function mount()
    // {
    //
    // }
}
