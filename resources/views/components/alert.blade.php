<div class="alert alert-{{ $type }} text-center" role="alert">
    {{ $slot }}
    @if($showCloseButton)
    <button type="button" class="close" data-dismiss="alert" aria-label="Close">
        <span aria-hidden="true">&times;</span>
    </button>
    @endif
</div>