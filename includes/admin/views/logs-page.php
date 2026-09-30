<?php
/**
 * Admin Logs Table View
 *
 * @package Signa_OTP
 * @var array  $logs_data
 * @var array  $stats
 * @var int    $paged
 * @var int    $per_page
 * @var string $search
 * @var string $status
 * @var string $channel
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

$items       = $logs_data['items'];
$total_items = $logs_data['total'];
$total_pages = ceil( $total_items / $per_page );

$status_labels = array(
	'sent'     => array( 'label' => 'ارسال شده (در انتظار)', 'class' => 'signa-badge-info' ),
	'verified' => array( 'label' => 'تایید و وارد شده', 'class' => 'signa-badge-success' ),
	'failed'   => array( 'label' => 'خطا در ارسال', 'class' => 'signa-badge-danger' ),
	'expired'  => array( 'label' => 'منقضی / باطل شده', 'class' => 'signa-badge-muted' ),
);
?>
<div class="wrap signa-admin-wrap" dir="rtl">
	<div class="signa-admin-header">
		<div>
			<h1>
				<span class="dashicons dashicons-list-view" style="font-size:28px;width:28px;height:28px;color:#2563eb;margin-left:8px;"></span>
				گزارش و لاگ کدهای یکبارمصرف (OTP Logs)
			</h1>
			<p class="signa-admin-subtitle">مشاهده وضعیت ارسال پیامک‌ها، پیام‌رسان بله، ایمیل‌ها و کدهای فعال (مفید برای تست بدون پنل پیامک)</p>
		</div>
		<div class="signa-header-actions">
			<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp' ) ); ?>" class="button button-secondary">
				بازگشت به تنظیمات
			</a>
		</div>
	</div>

	<?php // phpcs:ignore WordPress.Security.NonceVerification.Recommended ?>
	<?php if ( isset( $_GET['logs-cleared'] ) ) : ?>
		<div class="notice notice-success is-dismissible">
			<p><strong>لاگ‌ها با موفقیت پاکسازی شدند.</strong></p>
		</div>
	<?php endif; ?>

	<!-- Filter & Cleanup Bar -->
	<div class="signa-logs-toolbar">
		<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" class="signa-logs-filter-form">
			<input type="hidden" name="page" value="signa-otp-logs" />
			<input type="search" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="جستجوی شماره، ایمیل یا IP..." />
			<select name="status">
				<option value="">همه وضعیت‌ها</option>
				<option value="sent" <?php selected( $status, 'sent' ); ?>>ارسال شده (فعال)</option>
				<option value="verified" <?php selected( $status, 'verified' ); ?>>تایید شده</option>
				<option value="failed" <?php selected( $status, 'failed' ); ?>>ناموفق</option>
				<option value="expired" <?php selected( $status, 'expired' ); ?>>منقضی شده</option>
			</select>
			<select name="channel">
				<option value="">همه کانال‌ها</option>
				<option value="sms" <?php selected( $channel, 'sms' ); ?>>پیامک (SMS)</option>
				<option value="bale" <?php selected( $channel, 'bale' ); ?>>پیام‌رسان بله</option>
				<option value="email" <?php selected( $channel, 'email' ); ?>>ایمیل</option>
			</select>
			<button type="submit" class="button">فیلتر</button>
			<?php if ( ! empty( $search ) || ! empty( $status ) || ! empty( $channel ) ) : ?>
				<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ); ?>" class="button">پاک کردن فیلتر</a>
			<?php endif; ?>
		</form>

		<form method="post" action="" onsubmit="return confirm('آیا از پاکسازی لاگ‌ها اطمینان دارید؟');">
			<?php wp_nonce_field( 'signa_clear_logs_action', 'signa_logs_nonce' ); ?>
			<select name="clear_type">
				<option value="old">حذف لاگ‌های قدیمی</option>
				<option value="all">حذف تمام لاگ‌ها</option>
			</select>
			<button type="submit" name="signa_clear_logs" value="1" class="button button-link-delete">پاکسازی</button>
		</form>
	</div>

	<div class="signa-panel-card" style="padding:0;overflow:hidden;">
		<table class="wp-list-table widefat fixed striped signa-logs-table">
			<thead>
				<tr>
					<th style="width:60px;">شناسه</th>
					<th>گیرنده (موبایل / ایمیل)</th>
					<th style="width:110px;">کانال / درگاه</th>
					<th style="width:110px;">کد OTP</th>
					<th style="width:140px;">وضعیت</th>
					<th style="width:80px;">تلاش‌ها</th>
					<th>پاسخ وب‌سرویس</th>
					<th style="width:120px;">آدرس IP</th>
					<th style="width:150px;">زمان ارسال</th>
				</tr>
			</thead>
			<tbody>
				<?php if ( empty( $items ) ) : ?>
					<tr>
						<td colspan="9" style="text-align:center;padding:32px;color:#6b7280;">
							هیچ گزارشی یافت نشد.
						</td>
					</tr>
				<?php else : ?>
					<?php foreach ( $items as $row ) : ?>
						<?php
						$badge = isset( $status_labels[ $row->status ] )
							? $status_labels[ $row->status ]
							: array( 'label' => $row->status, 'class' => 'signa-badge-muted' );
						?>
						<tr>
							<td>#<?php echo esc_html( (string) $row->id ); ?></td>
							<td><strong dir="ltr" style="display:inline-block;"><?php echo esc_html( $row->recipient ); ?></strong></td>
							<td>
								<span class="signa-channel-pill"><?php echo esc_html( strtoupper( $row->channel ) ); ?></span>
								<small style="display:block;color:#6b7280;"><?php echo esc_html( $row->gateway ); ?></small>
							</td>
							<td>
								<code class="signa-otp-code-pill" dir="ltr"><?php echo esc_html( $row->otp_code ); ?></code>
							</td>
							<td>
								<span class="signa-badge <?php echo esc_attr( $badge['class'] ); ?>">
									<?php echo esc_html( $badge['label'] ); ?>
								</span>
							</td>
							<td><?php echo esc_html( (string) $row->attempts ); ?></td>
							<td style="font-size:12px;color:#374151;"><?php echo esc_html( $row->response_message ); ?></td>
							<td><code dir="ltr"><?php echo esc_html( $row->ip_address ); ?></code></td>
							<td>
								<span dir="ltr" style="font-size:12px;"><?php echo esc_html( $row->created_at ); ?></span>
							</td>
						</tr>
					<?php endforeach; ?>
				<?php endif; ?>
			</tbody>
		</table>
	</div>

	<?php if ( $total_pages > 1 ) : ?>
		<div class="tablenav bottom">
			<div class="tablenav-pages">
				<?php
				// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
				echo paginate_links(
					array(
						'base'      => add_query_arg( 'paged', '%#%' ),
						'format'    => '',
						'prev_text' => '&laquo; قبلی',
						'next_text' => 'بعدی &raquo;',
						'total'     => $total_pages,
						'current'   => $paged,
					)
				);
				?>
			</div>
		</div>
	<?php endif; ?>
</div>
