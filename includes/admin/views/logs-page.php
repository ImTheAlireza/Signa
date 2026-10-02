<?php
/**
 * Signa OTP v2.0 - Modern Logs & Analytics Table View
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

$export_csv_url = wp_nonce_url(
	add_query_arg(
		array(
			'page'                  => 'signa-otp-logs',
			'signa_export_logs_csv' => '1',
		),
		admin_url( 'admin.php' )
	),
	'signa_export_csv_action',
	'nonce'
);
?>
<div class="signa-app-shell" id="signa-app-shell" dir="rtl">
	<header class="signa-topbar">
		<div class="signa-topbar-brand">
			<div class="signa-brand-logo">
				<span class="dashicons dashicons-list-view" style="font-size:24px;width:24px;height:24px;"></span>
			</div>
			<div>
				<div class="signa-brand-title-row">
					<h1>گزارش و لاگ کدهای ارسالی (Signa Logs)</h1>
					<span class="signa-badge-ver"><?php echo esc_html( number_format_i18n( $total_items ) ); ?> رکورد</span>
				</div>
				<p>مشاهده وضعیت ارسال پیامک‌ها، بله، ایمیل‌ها و کدهای آزمایشی</p>
			</div>
		</div>

		<div class="signa-topbar-actions">
			<button type="button" id="signa-theme-toggle" class="signa-icon-btn" title="تغییر حالت روشن / تاریک">
				<span class="signa-dark-icon">🌙</span>
			</button>

			<a href="<?php echo esc_url( $export_csv_url ); ?>" class="signa-btn-secondary">
				<span class="dashicons dashicons-download"></span>
				خروجی اکسل (CSV)
			</a>

			<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp' ) ); ?>" class="signa-btn-save" style="text-decoration:none;">
				<span class="dashicons dashicons-admin-generic"></span>
				بازگشت به داشبورد و تنظیمات
			</a>
		</div>
	</header>

	<div style="padding:24px;">
		<!-- KPI Summary -->
		<div class="signa-kpi-grid" style="margin-bottom:20px;">
			<div class="signa-kpi-card">
				<div class="signa-kpi-icon is-blue"><span class="dashicons dashicons-email-alt"></span></div>
				<div class="signa-kpi-info">
					<span>کل کدهای ثبت‌شده</span>
					<strong><?php echo esc_html( number_format_i18n( $stats['total'] ) ); ?></strong>
				</div>
			</div>
			<div class="signa-kpi-card">
				<div class="signa-kpi-icon is-green"><span class="dashicons dashicons-yes-alt"></span></div>
				<div class="signa-kpi-info">
					<span>تایید و وارد شده</span>
					<strong><?php echo esc_html( number_format_i18n( $stats['verified'] ) ); ?></strong>
				</div>
			</div>
			<div class="signa-kpi-card">
				<div class="signa-kpi-icon is-purple"><span class="dashicons dashicons-calendar-alt"></span></div>
				<div class="signa-kpi-info">
					<span>ارسالی امروز</span>
					<strong><?php echo esc_html( number_format_i18n( $stats['today'] ) ); ?></strong>
				</div>
			</div>
			<div class="signa-kpi-card">
				<div class="signa-kpi-icon is-red"><span class="dashicons dashicons-warning"></span></div>
				<div class="signa-kpi-info">
					<span>خطا در ارسال</span>
					<strong><?php echo esc_html( number_format_i18n( $stats['failed'] ) ); ?></strong>
				</div>
			</div>
		</div>

		<!-- Filter & Cleanup Card -->
		<div class="signa-card" style="margin-bottom:20px;padding:16px 22px;">
			<div class="signa-logs-toolbar">
				<form method="get" action="<?php echo esc_url( admin_url( 'admin.php' ) ); ?>" class="signa-logs-filter-form">
					<input type="hidden" name="page" value="signa-otp-logs" />
					<input type="search" name="s" value="<?php echo esc_attr( $search ); ?>" placeholder="جستجوی شماره، ایمیل یا IP..." style="min-width:220px;" />
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
						<option value="passkey" <?php selected( $channel, 'passkey' ); ?>>بیومتریک (Passkey)</option>
					</select>
					<button type="submit" class="signa-btn-secondary">اعمال فیلتر</button>
					<?php if ( ! empty( $search ) || ! empty( $status ) || ! empty( $channel ) ) : ?>
						<a href="<?php echo esc_url( admin_url( 'admin.php?page=signa-otp-logs' ) ); ?>" class="signa-btn-secondary">حذف فیلتر</a>
					<?php endif; ?>
				</form>

				<form method="post" action="" onsubmit="return confirm('آیا از پاکسازی لاگ‌ها اطمینان دارید؟');" style="display:flex;gap:8px;align-items:center;">
					<?php wp_nonce_field( 'signa_clear_logs_action', 'signa_logs_nonce' ); ?>
					<select name="clear_type">
						<option value="old">حذف لاگ‌های قدیمی</option>
						<option value="all">پاک کردن تمام لاگ‌ها</option>
					</select>
					<button type="submit" name="signa_clear_logs" value="1" class="signa-btn-danger">پاکسازی</button>
				</form>
			</div>
		</div>

		<!-- Table Card -->
		<div class="signa-card" style="padding:0;overflow:hidden;">
			<table class="signa-modern-table">
				<thead>
					<tr>
						<th style="width:65px;">شناسه</th>
						<th>گیرنده (موبایل / ایمیل)</th>
						<th>کانال / درگاه</th>
						<th>کد OTP</th>
						<th>وضعیت</th>
						<th>تلاش‌ها</th>
						<th>پاسخ سرور / درگاه</th>
						<th>آدرس IP</th>
						<th>زمان ایجاد</th>
					</tr>
				</thead>
				<tbody>
					<?php if ( empty( $items ) ) : ?>
						<tr>
							<td colspan="9" style="text-align:center;padding:36px;color:#64748b;">
								هیچ لاگی مطابق با جستجوی شما یافت نشد.
							</td>
						</tr>
					<?php else : ?>
						<?php foreach ( $items as $row ) : ?>
							<tr>
								<td>#<?php echo esc_html( (string) $row->id ); ?></td>
								<td><strong dir="ltr"><?php echo esc_html( $row->recipient ); ?></strong></td>
								<td>
									<span class="signa-pill is-muted"><?php echo esc_html( strtoupper( $row->channel ) . ' / ' . $row->gateway ); ?></span>
								</td>
								<td>
									<code class="signa-otp-code-pill" dir="ltr"><?php echo esc_html( $row->otp_code ); ?></code>
								</td>
								<td>
									<?php if ( 'verified' === $row->status ) : ?>
										<span class="signa-pill is-ok">تایید و وارد شده</span>
									<?php elseif ( 'failed' === $row->status ) : ?>
										<span class="signa-pill is-err">خطا در ارسال</span>
									<?php elseif ( 'sent' === $row->status ) : ?>
										<span class="signa-pill is-info">ارسال شده (فعال)</span>
									<?php else : ?>
										<span class="signa-pill is-muted">منقضی شده</span>
									<?php endif; ?>
								</td>
								<td><?php echo esc_html( (string) $row->attempts ); ?></td>
								<td style="max-width:260px;font-size:12px;"><?php echo esc_html( $row->response_message ); ?></td>
								<td><code dir="ltr"><?php echo esc_html( $row->ip_address ); ?></code></td>
								<td dir="ltr" style="font-size:12px;"><?php echo esc_html( $row->created_at ); ?></td>
							</tr>
						<?php endforeach; ?>
					<?php endif; ?>
				</tbody>
			</table>
		</div>

		<?php if ( $total_pages > 1 ) : ?>
			<div class="tablenav bottom" style="margin-top:16px;">
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
</div>
