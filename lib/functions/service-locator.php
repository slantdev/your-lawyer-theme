<?php
/* change amount of posts returned by REST API to 100 */
function rest_service_provider_per_page( $args, $request ) {
    $max = max( (int)$request->get_param( 'per_page' ), 999999 );
    $args['posts_per_page'] = $max;
    return $args;
}
add_filter( 'rest_service_provider_query', 'rest_service_provider_per_page', 10, 2 );