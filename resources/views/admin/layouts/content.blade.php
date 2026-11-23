<div class="container-fluid pt-3">

    @if (session('success'))
        <div class="alert alert-success alert-soft alert-dismissible fade show" role="alert">
            <i class="fas fa-check-circle mr-1"></i> {{ session('success') }}
            <button type="button" class="close" data-dismiss="alert">&times;</button>
        </div>
    @endif

    @if ($content)
        @include($content)
    @endif

</div>