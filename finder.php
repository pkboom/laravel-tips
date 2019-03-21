<?php

if (is_dir($path)) {
    foreach (Finder::create()->files()->name('*.php')->in($path) as $file) {
        require $file->getRealPath();
    }
}
