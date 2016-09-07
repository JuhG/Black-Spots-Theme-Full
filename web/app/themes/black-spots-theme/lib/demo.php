<?php
foreach ( $_GET as $mod => $value) {
    add_filter( 'theme_mod_' . $mod , function ( $original ) use ($value) {
        return $value;
    });
}
