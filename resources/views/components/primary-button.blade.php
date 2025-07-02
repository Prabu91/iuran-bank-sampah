<button {{ $attributes->merge(['type' => 'submit', 'class' => 'inline-flex items-center px-4 py-2 bg-primary border border-transparent rounded-md font-semibold text-xs text-text-light uppercase tracking-widest hover:bg-hoverPrimary focus:bg-hoverPrimary active:bg-activePrimary focus:outline-none focus:ring-2 focus:ring-grey-500 focus:ring-offset-2 transition ease-in-out duration-150']) }}>
    {{ $slot }}
</button>
