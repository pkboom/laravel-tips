<?php

// @see https://twitter.com/LiamHammett/status/1273938829494403075
use Illuminate\validation\ValidationException;

throw ValidationException::WithMessages ([
'' => "You can't do that..."
]);

//////////////////////////////////////////////////

@error('')
<p>{{ $message }}</p>
@enderror
