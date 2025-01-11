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

    protected $rules = [
        'title' => 'required|min:3|max:255',
        'options' => 'required|array|min:2|max:10',
        'options.*' => 'required|min:1|max:255',
    ];

    protected $messages = [
        'options.*' => 'The option can\'t be empty.'
    ];

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

    /**
     * @param string $propertyName
     */
    public function updated($propertyName)
    {
        $this->validateOnly($propertyName);
    }

    /**
     * @return void
     */
    public function createPoll()
    {
        $this->validate();

        $poll = Poll::create([
            'title' => $this->title,
        ])->options()->createMany(
            collect($this->options)
                ->map(fn($option) => ['name' => $option])
                ->all()
        );

        // Replaced with the above code Laravel way
        // foreach($this->options as $optionName) {
        //     $poll->options()->create([
        //         'name' => $optionName,
        //     ]);
        // }

        $this->reset(['title', 'options']);

        $this->dispatch('pollCreated');
    }
}
