<div class="relative">
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
        value="{{ $value }}" id="{{ $name }}"
        class="pr-8 w-full rounded-md border-0 px-2.5 py-1.5 text-sm ring-1 ring-slate-300 placeholder:text-slate-400 focus:ring-2">
</div>
