@if (session()->has('flash_success'))
    <div class="alert alert-dismissible alert-success">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <p>{{ session()->get("flash_success") }}</p>
    </div>
@endif

@if (session()->has('flash_error'))
    <div class="alert alert-dismissible alert-danger">
        <button type="button" class="close" data-dismiss="alert">&times;</button>
        <h4>Error!</h4>
        <p>{{ session()->get("flash_error") }}</p>
    </div>
@endif
