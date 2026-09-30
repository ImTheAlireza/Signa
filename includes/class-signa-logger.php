<?php
/**
 * OTP Logger & Log Table Repository
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Logger {

	/**
	 * Get table name
	 *
	 * @return string
	 */
	public static function table_name() {
		global $wpdb;
		return $wpdb->prefix . 'signa_otp_logs';
	}

	/**
	 * Insert a new OTP log/session entry
	 *
	 * @param array $data Log data.
	 * @return int|false Inserted ID or false on error.
	 */
	public static function insert( $data ) {
		global $wpdb;

		$now        = current_time( 'mysql' );
		$expiry_sec = absint( Signa_Helper::get_option( 'otp_expiry', 120 ) );
		$expires_at = gmdate( 'Y-m-d H:i:s', strtotime( $now ) + $expiry_sec );

		$defaults = array(
			'recipient'        => '',
			'channel'          => 'sms',
			'gateway'          => 'sandbox',
			'otp_code'         => '',
			'otp_hash'         => '',
			'status'           => 'sent',
			'attempts'         => 0,
			'ip_address'       => Signa_Helper::get_client_ip(),
			'response_message' => '',
			'expires_at'       => $expires_at,
			'verified_at'      => null,
			'created_at'       => $now,
		);

		$row = wp_parse_args( $data, $defaults );

		// Expire previous active codes for this recipient
		self::expire_previous_codes( $row['recipient'] );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery
		$result = $wpdb->insert(
			self::table_name(),
			array(
				'recipient'        => $row['recipient'],
				'channel'          => $row['channel'],
				'gateway'          => $row['gateway'],
				'otp_code'         => $row['otp_code'],
				'otp_hash'         => $row['otp_hash'],
				'status'           => $row['status'],
				'attempts'         => (int) $row['attempts'],
				'ip_address'       => $row['ip_address'],
				'response_message' => $row['response_message'],
				'expires_at'       => $row['expires_at'],
				'verified_at'      => $row['verified_at'],
				'created_at'       => $row['created_at'],
			),
			array( '%s', '%s', '%s', '%s', '%s', '%s', '%d', '%s', '%s', '%s', '%s', '%s' )
		);

		if ( false === $result ) {
			return false;
		}

		return (int) $wpdb->insert_id;
	}

	/**
	 * Mark previous sent codes for recipient as expired
	 *
	 * @param string $recipient Phone or email.
	 */
	public static function expire_previous_codes( $recipient ) {
		global $wpdb;
		$table = self::table_name();

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		$wpdb->query(
			$wpdb->prepare(
				"UPDATE {$table} SET status = 'expired' WHERE recipient = %s AND status = 'sent'",
				$recipient
			)
		);
	}

	/**
	 * Update log status and message
	 *
	 * @param int   $id     Log ID.
	 * @param array $fields Fields to update.
	 * @return bool
	 */
	public static function update( $id, $fields ) {
		global $wpdb;
		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		return (bool) $wpdb->update(
			self::table_name(),
			$fields,
			array( 'id' => absint( $id ) )
		);
	}

	/**
	 * Get latest active OTP record for a recipient
	 *
	 * @param string $recipient Normalized phone or email.
	 * @return object|null
	 */
	public static function get_latest_record( $recipient ) {
		global $wpdb;
		$table = self::table_name();

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching
		return $wpdb->get_row(
			$wpdb->prepare(
				"SELECT * FROM {$table} WHERE recipient = %s ORDER BY id DESC LIMIT 1",
				$recipient
			)
		);
	}

	/**
	 * Get paginated logs for admin page
	 *
	 * @param array $args Query arguments.
	 * @return array { items: array, total: int }
	 */
	public static function get_logs( $args = array() ) {
		global $wpdb;
		$table = self::table_name();

		$defaults = array(
			'per_page' => 20,
			'paged'    => 1,
			'search'   => '',
			'status'   => '',
			'channel'  => '',
		);
		$args     = wp_parse_args( $args, $defaults );

		$where  = array( '1=1' );
		$values = array();

		if ( ! empty( $args['search'] ) ) {
			$where[]  = '(recipient LIKE %s OR ip_address LIKE %s OR gateway LIKE %s)';
			$like     = '%' . $wpdb->esc_like( $args['search'] ) . '%';
			$values[] = $like;
			$values[] = $like;
			$values[] = $like;
		}

		if ( ! empty( $args['status'] ) ) {
			$where[]  = 'status = %s';
			$values[] = $args['status'];
		}

		if ( ! empty( $args['channel'] ) ) {
			$where[]  = 'channel = %s';
			$values[] = $args['channel'];
		}

		$where_sql = implode( ' AND ', $where );
		$offset    = max( 0, ( absint( $args['paged'] ) - 1 ) * absint( $args['per_page'] ) );
		$limit     = absint( $args['per_page'] );

		if ( ! empty( $values ) ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$total = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE {$where_sql}", $values ) );

			$query_values   = $values;
			$query_values[] = $limit;
			$query_values[] = $offset;
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} WHERE {$where_sql} ORDER BY id DESC LIMIT %d OFFSET %d", $query_values ) );
		} else {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$total = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			$items = $wpdb->get_results( $wpdb->prepare( "SELECT * FROM {$table} ORDER BY id DESC LIMIT %d OFFSET %d", $limit, $offset ) );
		}

		return array(
			'items' => is_array( $items ) ? $items : array(),
			'total' => $total,
		);
	}

	/**
	 * Get summary statistics for admin dashboard
	 *
	 * @return array
	 */
	public static function get_stats() {
		global $wpdb;
		$table = self::table_name();
		$today = gmdate( 'Y-m-d 00:00:00', strtotime( current_time( 'mysql' ) ) );

		// phpcs:disable WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		$total_all      = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table}" );
		$today_count    = (int) $wpdb->get_var( $wpdb->prepare( "SELECT COUNT(*) FROM {$table} WHERE created_at >= %s", $today ) );
		$verified_count = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE status = 'verified'" );
		$failed_count   = (int) $wpdb->get_var( "SELECT COUNT(*) FROM {$table} WHERE status = 'failed'" );
		// phpcs:enable

		return array(
			'total'    => $total_all,
			'today'    => $today_count,
			'verified' => $verified_count,
			'failed'   => $failed_count,
		);
	}

	/**
	 * Clear all logs or logs older than retention period
	 *
	 * @param bool $all Whether to truncate all logs.
	 * @return int Number of rows deleted.
	 */
	public static function clear_logs( $all = false ) {
		global $wpdb;
		$table = self::table_name();

		if ( $all ) {
			// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
			return (int) $wpdb->query( "TRUNCATE TABLE {$table}" );
		}

		$days   = max( 1, absint( Signa_Helper::get_option( 'log_retention_days', 30 ) ) );
		$cutoff = gmdate( 'Y-m-d H:i:s', strtotime( current_time( 'mysql' ) ) - ( $days * DAY_IN_SECONDS ) );

		// phpcs:ignore WordPress.DB.DirectDatabaseQuery.DirectQuery, WordPress.DB.DirectDatabaseQuery.NoCaching, WordPress.DB.PreparedSQL.InterpolatedNotPrepared
		return (int) $wpdb->query( $wpdb->prepare( "DELETE FROM {$table} WHERE created_at < %s", $cutoff ) );
	}
}
