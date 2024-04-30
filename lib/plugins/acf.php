<?php

// ACF Google Maps API
function gs_acf_google_map_api( $api ){
    $api['key'] = 'AIzaSyBpcSnbl_ieptoA7brm_tG3xjcJUO1aVlo';
    return $api;
}
add_filter('acf/fields/google_map/api', 'gs_acf_google_map_api');