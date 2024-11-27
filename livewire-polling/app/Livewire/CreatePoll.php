<?php

namespace App\Livewire;

use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Foundation\Application;
use Livewire\Component;

class CreatePoll extends Component
{
    public string $title;
    public array $options = ['']; // need first empty option for user to input

    /**
     * @return Factory|View|Application|\Illuminate\Contracts\Foundation\Application
     */
    public function render(): Factory|View|Application|\Illuminate\Contracts\Foundation\Application
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

    // public function mount()
    // {
    //
    // }
}
