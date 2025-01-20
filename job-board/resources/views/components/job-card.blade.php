<x-card class="mb-4">
    <div class="mb-4flex justify-between">
        <h2 class="text-xl font-medium">{{ $job->title }}</h2>
        <div class="text-slate-500">
            ${{ number_format($job->salary) }}
        </div>
    </div>

    <div class="mb-4 flex item-center justify-between text-sm text-slate-500 items-center">
        <div class="flex space-x-4">
            <div>{{ $job->employer->company_name }}</div>
            <div>{{ $job->location }}</div>
        </div>
        <div class="flex space-x-1 text-sm">
            <x-tag>
                <a href="{{ route('jobs.index', ['experience' => $job->experience]) }}">{{ Str::ucfirst($job->experience) }}</a>
            </x-tag>
            <x-tag>
                <a href="{{ route('jobs.index', ['category' => $job->category]) }}">{{ $job->category }}</a>
            </x-tag>
        </div>
    </div>

    {{ $slot }}
</x-card>
