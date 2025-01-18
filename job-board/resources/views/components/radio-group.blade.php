<div>
    <label for="{{ $name }}" class="mb-1 flex items-center">
        <input type="radio" id="{{ $name }}" name="{{ $name }}" value=""
            @checked(!request($name))>
        <span class="ml-2">All</span>
    </label>
    @foreach ($options as $option)
        <label for="{{ $option }}" class="mb-1 flex items-center">
            <input type="radio" id="{{ $option }}" name="{{ $name }}" value="{{ $option }}"
                @checked($option === request($name))>
            <span class="ml-2">{{ $option }}</span>
        </label>
    @endforeach

</div>
