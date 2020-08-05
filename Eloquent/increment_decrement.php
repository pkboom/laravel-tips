<?php

$license = App\License::find(1);
$license->maximum_activations++;
$license->save();

// update 'licenses' set 'maximum_activations' = ?, 'updated_at' = ? where 'id' = ?


$license = App\License::find(1);
$license->increment('maximum_activations');
// update 'licenses' set 'maximum_activations' = 'maximum_activations' + 1, 'updated_at' = ? where 'id' = ?
