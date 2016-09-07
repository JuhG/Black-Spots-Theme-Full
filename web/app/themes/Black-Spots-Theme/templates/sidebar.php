<?php
use BlackSpots\Setup;

if ( Setup\alternative_template() ) {
    dynamic_sidebar('sidebar-alternative');
} else {
    dynamic_sidebar('sidebar-primary');
}
