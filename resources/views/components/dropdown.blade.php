@props([
    'align' => 'right',
    'width' => '48',
    'contentClasses' => 'py-1 bg-white',
])

@php
    $alignmentClasses = match ($align) {
        'left' => 'ltr:origin-top-left rtl:origin-top-right start-0',
        'top' => 'origin-top',
        default => 'ltr:origin-top-right rtl:origin-top-left end-0',
    };

    $widthClass = match ($width) {
        '48' => 'w-48',
        default => 'w-48',
    };
@endphp


<div class="relative" x-data="{ open: false }">

    <div @click.stop="open=!open">

        {{ $trigger }}

    </div>


    <div x-cloak x-show="open" @click.outside="open=false" x-transition
        class="
absolute
{{ $widthClass }}
{{ $alignmentClasses }}

mt-2

rounded-md

shadow-lg

z-[9999]

">

        <div class="
rounded-md
ring-1
ring-black/5
{{ $contentClasses }}">

            {{ $content }}

        </div>

    </div>

</div>
