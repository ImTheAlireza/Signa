<?php
/**
 * Uninstall Signa OTP Plugin
 *
 * @package Signa_OTP
 */

if ( ! defined( 'WP_UNINSTALL_PLUGIN' ) ) {
	exit;
}

wp_clear_scheduled_hook( 'signa_otp_daily_cleanup' );

$settings = get_option( 'signa_otp_settings', array() );

if ( ! empty( $settings['delete_data_on_uninstall'] ) ) {
	global $wpdb;

	$logs_table = $wpdb->prefix . 'signa_otp_logs';
	// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.DirectDatabaseQuery.SchemaChange
	$wpdb->query( "DROP TABLE IF EXISTS {$logs_table}" );

	delete_option( 'signa_otp_settings' );
	delete_option( 'signa_otp_db_version' );
	delete_option( 'signa_active_lockouts' );
	delete_transient( 'signa_bale_safir_token' );
	delete_transient( 'signa_admin_stats_cache' );
	delete_transient( 'signa_admin_chart_cache' );
}
