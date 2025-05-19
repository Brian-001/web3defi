{{-- <svg xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24" stroke-width="1.5" stroke="currentColor" class="size-4">
  <path stroke-linecap="round" stroke-linejoin="round" d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" />
</svg> --}}

<div 
    x-data="{ 
        copied: false, 
        tooltipText: 'Copy URL', 
        init() {
            const tooltip = this.$refs.tooltip;
            const icon = this.$el.querySelector('svg');
            this.popper = Popper.createPopper(icon, tooltip, {
                placement: 'top',
                modifiers: [{ name: 'offset', options: { offset: [0, 6] } }],
            });
        },
        showTooltip() {
            this.$refs.tooltip.classList.remove('invisible', 'opacity-0');
            this.$refs.tooltip.classList.add('visible', 'opacity-100');
            this.popper.update();
        },
        hideTooltip() {
            this.$refs.tooltip.classList.remove('visible', 'opacity-100');
            this.$refs.tooltip.classList.add('invisible', 'opacity-0');
        }
    }" 
    x-on:mouseenter="showTooltip()" 
    x-on:mouseleave="hideTooltip()" 
    class="relative inline-flex items-center"
>
    <svg 
        xmlns="http://www.w3.org/2000/svg" 
        fill="none" 
        viewBox="0 0 24 24" 
        stroke-width="1.5" 
        stroke="currentColor" 
        class="size-4 cursor-pointer text-gray-500 hover:text-cyan-600 transition-colors duration-200" 
        x-on:click="
            navigator.clipboard.writeText($el.getAttribute('data-url')); 
            copied = true; 
            tooltipText = 'Copied!'; 
            setTimeout(() => { copied = false; tooltipText = 'Copy URL' }, 2000)
        " 
        x-bind:class="{ 'text-green-500': copied }" 
        data-url="{{ $attributes['data-url'] ?? '' }}"
        aria-label="Copy URL"
    >
        <path 
            stroke-linecap="round" 
            stroke-linejoin="round" 
            d="M8.25 7.5V6.108c0-1.135.845-2.098 1.976-2.192.373-.03.748-.057 1.123-.08M15.75 18H18a2.25 2.25 0 0 0 2.25-2.25V6.108c0-1.135-.845-2.098-1.976-2.192a48.424 48.424 0 0 0-1.123-.08M15.75 18.75v-1.875a3.375 3.375 0 0 0-3.375-3.375h-1.5a1.125 1.125 0 0 1-1.125-1.125v-1.5A3.375 3.375 0 0 0 6.375 7.5H5.25m11.9-3.664A2.251 2.251 0 0 0 15 2.25h-1.5a2.251 2.251 0 0 0-2.15 1.586m5.8 0c.065.21.1.433.1.664v.75h-6V4.5c0-.231.035-.454.1-.664M6.75 7.5H4.875c-.621 0-1.125.504-1.125 1.125v12c0 .621.504 1.125 1.125 1.125h9.75c.621 0 1.125-.504 1.125-1.125V16.5a9 9 0 0 0-9-9Z" 
        />
    </svg>
    <div 
        x-ref="tooltip" 
        role="tooltip" 
        class="absolute z-10 invisible inline-flex items-center px-2 py-1 text-xs font-medium text-white bg-gray-900 rounded-md shadow-xs opacity-0 transition-opacity duration-300 dark:bg-gray-700 whitespace-nowrap"
        x-text="tooltipText"
    >
        <div class="tooltip-arrow" data-popper-arrow></div>
    </div>
</div>
