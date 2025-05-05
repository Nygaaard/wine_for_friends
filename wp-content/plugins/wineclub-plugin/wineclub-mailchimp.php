<?php
/**
 * Plugin Name: Wine Club Mailchimp 
 * Description: Registrerar REST API-endpoint för att lägga till e-post i Mailchimp
 * Version: 1.0
 * Author: Andreas Nygård
 */

add_action('rest_api_init', function () {
  register_rest_route('vinklubb/v1', '/subscribe', [
    'methods' => 'POST',
    'callback' => 'vinklubb_subscribe',
    'permission_callback' => '__return_true',
  ]);
});

function vinklubb_subscribe($request) {
  $email = sanitize_email($request->get_param('email'));

  $api_key = 'd4e8fb25180eee816f30354d65aa1388-us13';
  $audience_id = '8aada76252';
  $dc = explode('-', $api_key)[1]; 

  $response = wp_remote_post("https://$dc.api.mailchimp.com/3.0/lists/$audience_id/members", [
    'headers' => [
      'Authorization' => 'apikey ' . $api_key,
      'Content-Type' => 'application/json',
    ],
    'body' => json_encode([
      'email_address' => $email,
      'status' => 'subscribed',
    ]),
  ]);

  if (is_wp_error($response)) {
    return new WP_Error('mailchimp_error', 'Fel vid anslutning till Mailchimp', ['status' => 500]);
  }

  $code = wp_remote_retrieve_response_code($response);
  if ($code === 200 || $code === 201) {
    return rest_ensure_response(['success' => true]);
  } else {
    $body = json_decode(wp_remote_retrieve_body($response), true);
    return new WP_Error('mailchimp_error', $body['detail'] ?? 'Något gick fel', ['status' => 400]);
  }
}
