<?php
/**
 * Elementor Widget: Signa OTP Login & Registration Card
 *
 * @package Signa_OTP
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

class Signa_Elementor_Login_Widget extends \Elementor\Widget_Base {

	/**
	 * Widget unique name
	 *
	 * @return string
	 */
	public function get_name() {
		return 'signa_otp_login_widget';
	}

	/**
	 * Widget title in Elementor panel
	 *
	 * @return string
	 */
	public function get_title() {
		return 'فرم ورود و ثبت‌نام یکبارمصرف (Signa)';
	}

	/**
	 * Widget icon
	 *
	 * @return string
	 */
	public function get_icon() {
		return 'eicon-lock-user';
	}

	/**
	 * Widget categories
	 *
	 * @return array
	 */
	public function get_categories() {
		return array( 'signa-otp', 'general' );
	}

	/**
	 * Search keywords in Elementor panel
	 *
	 * @return array
	 */
	public function get_keywords() {
		return array( 'otp', 'login', 'sms', 'signa', 'ورود', 'ثبت نام', 'پیامک', 'سیگنا', 'موبایل' );
	}

	/**
	 * Register widget controls
	 */
	protected function register_controls() {
		// 1. Content Section
		$this->start_controls_section(
			'section_content',
			array(
				'label' => 'محتوا و تنظیمات فرم',
				'tab'   => \Elementor\Controls_Manager::TAB_CONTENT,
			)
		);

		$this->add_control(
			'form_title',
			array(
				'label'       => 'عنوان فرم',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => Signa_Helper::get_option( 'form_title', 'ورود / ثبت‌نام' ),
				'placeholder' => 'ورود / ثبت‌نام',
				'label_block' => true,
			)
		);

		$this->add_control(
			'form_subtitle',
			array(
				'label'       => 'زیرعنوان فرم',
				'type'        => \Elementor\Controls_Manager::TEXTAREA,
				'default'     => Signa_Helper::get_option( 'form_subtitle', 'برای ادامه، شماره موبایل یا ایمیل خود را وارد کنید.' ),
				'rows'        => 2,
				'label_block' => true,
			)
		);

		$this->add_control(
			'button_text',
			array(
				'label'       => 'متن دکمه مرحله اول',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => Signa_Helper::get_option( 'button_text', 'دریافت کد تایید' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'verify_button_text',
			array(
				'label'       => 'متن دکمه تایید کد',
				'type'        => \Elementor\Controls_Manager::TEXT,
				'default'     => Signa_Helper::get_option( 'verify_button_text', 'تایید و ورود به حساب' ),
				'label_block' => true,
			)
		);

		$this->add_control(
			'redirect_url',
			array(
				'label'       => 'لینک ریدایرکت سفارشی پس از ورود (اختیاری)',
				'type'        => \Elementor\Controls_Manager::URL,
				'placeholder' => 'https://example.com/my-account',
				'options'     => false,
				'label_block' => true,
			)
		);

		$this->add_control(
			'show_in_editor',
			array(
				'label'        => 'نمایش فرم در محیط ویرایشگر (هنگام لاگین بودن)',
				'description'  => 'فعال باشد تا هنگام طراحی در المنتور، به جای باکس «شما وارد شده‌اید»، خود فرم ورود را ببینید.',
				'type'         => \Elementor\Controls_Manager::SWITCHER,
				'label_on'     => 'بله',
				'label_off'    => 'خیر',
				'return_value' => 'yes',
				'default'      => 'yes',
			)
		);

		$this->end_controls_section();

		// 2. Style Section
		$this->start_controls_section(
			'section_style_card',
			array(
				'label' => 'طراحی و رنگ‌بندی کارت فرم',
				'tab'   => \Elementor\Controls_Manager::TAB_STYLE,
			)
		);

		$this->add_control(
			'primary_color',
			array(
				'label'   => 'رنگ اصلی برند و دکمه‌ها',
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => Signa_Helper::get_option( 'primary_color', '#2563eb' ),
			)
		);

		$this->add_control(
			'card_bg_color',
			array(
				'label'   => 'رنگ پس‌زمینه کارت فرم',
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => Signa_Helper::get_option( 'card_bg_color', '#ffffff' ),
			)
		);

		$this->add_control(
			'text_color',
			array(
				'label'   => 'رنگ متون فرم',
				'type'    => \Elementor\Controls_Manager::COLOR,
				'default' => Signa_Helper::get_option( 'text_color', '#111827' ),
			)
		);

		$this->add_control(
			'digit_box_style',
			array(
				'label'   => 'استایل باکس‌های کد تایید',
				'type'    => \Elementor\Controls_Manager::SELECT,
				'default' => Signa_Helper::get_option( 'digit_box_style', 'box' ),
				'options' => array(
					'box'       => 'مربعی کلاسیک (Box)',
					'underline' => 'خط زیرین مینیمال (Underline)',
					'pill'      => 'کپسولی گرد (Pill)',
				),
			)
		);

		$this->add_control(
			'border_radius',
			array(
				'label'      => 'گردی گوشه‌های کارت (px)',
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 0,
						'max' => 32,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => absint( Signa_Helper::get_option( 'border_radius', 16 ) ),
				),
			)
		);

		$this->add_control(
			'form_max_width',
			array(
				'label'      => 'حداکثر عرض کارت (px)',
				'type'       => \Elementor\Controls_Manager::SLIDER,
				'size_units' => array( 'px' ),
				'range'      => array(
					'px' => array(
						'min' => 320,
						'max' => 640,
					),
				),
				'default'    => array(
					'unit' => 'px',
					'size' => absint( Signa_Helper::get_option( 'form_max_width', 420 ) ),
				),
			)
		);

		$this->end_controls_section();
	}

	/**
	 * Render widget output on the frontend and Elementor editor
	 */
	protected function render() {
		$settings    = $this->get_settings_for_display();
		$is_editor   = Signa_Elementor::is_editor_or_preview();
		$show_logged = ( 'yes' === ( $settings['show_in_editor'] ?? 'yes' ) && $is_editor );

		Signa_Frontend::instance()->enqueue_assets( true );

		if ( is_user_logged_in() && ! $show_logged ) {
			$user         = wp_get_current_user();
			$account_link = function_exists( 'wc_get_page_permalink' ) ? wc_get_page_permalink( 'myaccount' ) : admin_url( 'profile.php' );
			$logout_link  = wp_logout_url( home_url( '/' ) );

			echo sprintf(
				'<div class="signa-otp-wrapper" dir="rtl"><div class="signa-otp-card signa-logged-in-box"><p>سلام <strong>%s</strong>، شما وارد حساب کاربری خود شده‌اید.</p><div class="signa-logged-actions"><a href="%s" class="signa-btn signa-btn-primary">حساب کاربری</a><a href="%s" class="signa-btn signa-btn-outline">خروج</a></div></div></div>',
				esc_html( $user->display_name ),
				esc_url( $account_link ),
				esc_url( $logout_link )
			);
			return;
		}

		$redirect_url = ! empty( $settings['redirect_url']['url'] ) ? $settings['redirect_url']['url'] : '';
		$radius       = isset( $settings['border_radius']['size'] ) ? absint( $settings['border_radius']['size'] ) : null;
		$max_width    = isset( $settings['form_max_width']['size'] ) ? absint( $settings['form_max_width']['size'] ) : null;

		// phpcs:ignore WordPress.Security.EscapeOutput.OutputNotEscaped
		echo Signa_Frontend::get_login_form_html(
			array(
				'title'              => $settings['form_title'] ?? '',
				'subtitle'           => $settings['form_subtitle'] ?? '',
				'button_text'        => $settings['button_text'] ?? '',
				'verify_button_text' => $settings['verify_button_text'] ?? '',
				'redirect'           => $redirect_url,
				'primary_color'      => $settings['primary_color'] ?? '',
				'card_bg_color'      => $settings['card_bg_color'] ?? '',
				'text_color'         => $settings['text_color'] ?? '',
				'digit_box_style'    => $settings['digit_box_style'] ?? '',
				'border_radius'      => $radius,
				'max_width'          => $max_width,
				'context'            => 'elementor',
			)
		);
	}
}
