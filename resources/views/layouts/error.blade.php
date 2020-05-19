@if ($errors->has($error))

    <span class="invalid-feedback" role="alert">
        <strong>{{ $errors->first($error) }}</strong>
    </span>
@endif
