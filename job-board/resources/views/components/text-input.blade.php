<div class="relative">
    @if ('textarea' !== $type)
        @if ($formRef)
        <button type="button" class="absolute top-1/2 -translate-y-1/2 right-2 focus:outline-none"
            @onclick="$refs['input-{{ $name }}'].value = ''; $refs[{{ $formRef }}].submit();">
            <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor"
                class="size-6 text-slate-300 text-sm">
                <path stroke-linecap="round" stroke-linejoin="round" d="M6 18 18 6M6 6l12 12" />
            </svg>
        </button>
        @endif
        <input x-ref="input-{{ $name }}" type="{{ $type }}" name="{{ $name }}" placeholder="{{ $placeholder }}"
            value="{{ old($name, $value) }}" id="{{ $name }}"
            @class([
                'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2',
                'pr-8' => $formRef,
                'ring-slate-300' => !$errors->has($name),
                'ring-red-300' => $errors->has($name),
            ]) />
    @else
        <textarea name="{{ $name }}" placeholder="{{ $placeholder }}" id="{{ $name }}"
            @class([
                'w-full rounded-md border-0 py-1.5 px-2.5 text-sm ring-1 placeholder:text-slate-400 focus:ring-2',
                'pr-8' => $formRef,
                'ring-slate-300' => !$errors->has($name),
                'ring-red-300' => $errors->has($name),
            ])>{{ old($name, $value) }}</textarea>
    @endif

    @error($name)
        <div class="text-red-500 text-xs mt-1">{{ $message }}</div>
    @enderror
</div>
