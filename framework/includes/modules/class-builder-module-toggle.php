<?php
class Tm_Builder_Module_Toggle extends Tm_Builder_Module {
	function init() {
		$this->name                       = esc_html__( 'Toggle', 'power-builder' );
		$this->icon                       = 'f001';
		$this->slug                       = 'tm_pb_toggle';
		$this->additional_shortcode_slugs = array( 'tm_pb_accordion_item' );
		$this->icon = 'f205';

		$this->whitelisted_fields = array(
			'title',
			'open',
			'content_new',
			'admin_label',
			'module_id',
			'module_class',
			'open_toggle_background_color',
			'closed_toggle_background_color',
			'icon_color',
			'closed_toggle_text_color',
			'open_toggle_text_color',
		);

		$this->fields_defaults = array(
			'open' => array( 'off' ),
		);

		$this->main_css_element = '%%order_class%%.tm_pb_toggle';
		$this->advanced_options = array(
			'fonts' => array(
				'title' => array(
					'label'    => esc_html__( 'Title', 'power-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} h5",
					),
					'hide_text_color' => true,
				),
				'body'   => array(
					'label'    => esc_html__( 'Body', 'power-builder' ),
					'css'      => array(
						'main' => "{$this->main_css_element} .tm_pb_toggle_content",
					),
				),
			),
			'border' => array(),
			'custom_margin_padding' => array(
				'use_margin' => false,
				'css' => array(
					'important' => 'all',
				),
			),
		);
		$this->custom_css_options = array(
			'open_toggle' => array(
				'label'    => esc_html__( 'Open Toggle', 'power-builder' ),
				'selector' => '.tm_pb_toggle_open',
			),
			'toggle_title' => array(
				'label'    => esc_html__( 'Toggle Title', 'power-builder' ),
				'selector' => '.tm_pb_toggle_title',
			),
			'toggle_icon' => array(
				'label'    => esc_html__( 'Toggle Icon', 'power-builder' ),
				'selector' => '.tm_pb_toggle_title:before',
			),
			'toggle_content' => array(
				'label'    => esc_html__( 'Toggle Content', 'power-builder' ),
				'selector' => '.tm_pb_toggle_content',
			),
		);
	}

	function get_fields() {
		$fields = array(
			'title' => array(
				'label'           => esc_html__( 'Title', 'power-builder' ),
				'type'            => 'text',
				'option_category' => 'basic_option',
				'description'     => esc_html__( 'The toggle title will appear above the content and when the toggle is closed.', 'power-builder' ),
			),
			'open' => array(
				'label'           => esc_html__( 'State', 'power-builder' ),
				'type'            => 'select',
				'option_category' => 'basic_option',
				'options'         => array(
					'off' => esc_html__( 'Close', 'power-builder' ),
					'on'  => esc_html__( 'Open', 'power-builder' ),
				),
				'description' => esc_html__( 'Choose whether or not this toggle should start in an open or closed state.', 'power-builder' ),
			),
			'content_new' => array(
				'label'             => esc_html__( 'Content', 'power-builder' ),
				'type'              => 'tiny_mce',
				'option_category'   => 'basic_option',
				'description'       => esc_html__( 'Input the main text content for your module here.', 'power-builder' ),
			),
			'open_toggle_background_color' => array(
				'label'             => esc_html__( 'Open Toggle Background Color', 'power-builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'open_toggle_text_color' => array(
				'label'             => esc_html__( 'Open Toggle Text Color', 'power-builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'closed_toggle_background_color' => array(
				'label'             => esc_html__( 'Closed Toggle Background Color', 'power-builder' ),
				'type'              => 'color-alpha',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'closed_toggle_text_color' => array(
				'label'             => esc_html__( 'Closed Toggle Text Color', 'power-builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'icon_color' => array(
				'label'             => esc_html__( 'Icon Color', 'power-builder' ),
				'type'              => 'color',
				'custom_color'      => true,
				'tab_slug'          => 'advanced',
			),
			'disabled_on' => array(
				'label'           => esc_html__( 'Disable on', 'power-builder' ),
				'type'            => 'multiple_checkboxes',
				'options'         => tm_pb_media_breakpoints(),
				'additional_att'  => 'disable_on',
				'option_category' => 'configuration',
				'description'     => esc_html__( 'This will disable the module on selected devices', 'power-builder' ),
			),
			'admin_label' => array(
				'label'       => esc_html__( 'Admin Label', 'power-builder' ),
				'type'        => 'text',
				'description' => esc_html__( 'This will change the label of the module in the builder for easy identification.', 'power-builder' ),
			),
			'module_id' => array(
				'label'           => esc_html__( 'CSS ID', 'power-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'tm_pb_custom_css_regular',
			),
			'module_class' => array(
				'label'           => esc_html__( 'CSS Class', 'power-builder' ),
				'type'            => 'text',
				'option_category' => 'configuration',
				'tab_slug'        => 'custom_css',
				'option_class'    => 'tm_pb_custom_css_regular',
			),
		);
		return $fields;
	}

	function shortcode_callback( $atts, $content = null, $function_name ) {
		$module_id                      = $this->shortcode_atts['module_id'];
		$module_class                   = $this->shortcode_atts['module_class'];
		$title                          = $this->shortcode_atts['title'];
		$open                           = $this->shortcode_atts['open'];
		$open_toggle_background_color   = $this->shortcode_atts['open_toggle_background_color'];
		$closed_toggle_background_color = $this->shortcode_atts['closed_toggle_background_color'];
		$icon_color                     = $this->shortcode_atts['icon_color'];
		$closed_toggle_text_color       = $this->shortcode_atts['closed_toggle_text_color'];
		$open_toggle_text_color         = $this->shortcode_atts['open_toggle_text_color'];

		$module_class = TM_Builder_Element::add_module_order_class( $module_class, $function_name );

		if ( '' !== $open_toggle_background_color ) { TM_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.tm_pb_toggle_open',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $open_toggle_background_color )
				),
			) );
		}

		if ( '' !== $closed_toggle_background_color ) { TM_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.tm_pb_toggle_close',
				'declaration' => sprintf(
					'background-color: %1$s;',
					esc_html( $closed_toggle_background_color )
				),
			) );
		}

		if ( '' !== $icon_color ) { TM_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%% .tm_pb_toggle_title:before',
				'declaration' => sprintf(
					'color: %1$s;',
					esc_html( $icon_color )
				),
			) );
		}

		if ( '' !== $closed_toggle_text_color ) { TM_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.tm_pb_toggle_close h5.tm_pb_toggle_title',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $closed_toggle_text_color )
				),
			) );
		}

		if ( '' !== $open_toggle_text_color ) { TM_Builder_Element::set_style( $function_name, array(
				'selector'    => '%%order_class%%.tm_pb_toggle_open h5.tm_pb_toggle_title',
				'declaration' => sprintf(
					'color: %1$s !important;',
					esc_html( $open_toggle_text_color )
				),
			) );
		}

		if ( 'tm_pb_accordion_item' === $function_name ) {
			global $tm_pb_accordion_item_number;

			$open = 1 === $tm_pb_accordion_item_number ? 'on' : 'off';

			$tm_pb_accordion_item_number++;
		}

		// Adding "_item" class for toggle module for customizer targetting. There's no proper selector
		// for toggle module styles since both accordion and toggle module use the same selector
		if( 'tm_pb_toggle' === $function_name ){
			$module_class .= " tm_pb_toggle_item";
		}

		$output = sprintf(
			'<div%4$s class="tm_pb_module tm_pb_toggle %2$s%5$s">
				<h5 class="tm_pb_toggle_title">%1$s</h5>
				<div class="tm_pb_toggle_content clearfix">
					%3$s
				</div> <!-- .tm_pb_toggle_content -->
			</div> <!-- .tm_pb_toggle -->',
			esc_html( $title ),
			( 'on' === $open ? 'tm_pb_toggle_open' : 'tm_pb_toggle_close' ),
			$this->shortcode_content,
			( '' !== $module_id ? sprintf( ' id="%1$s"', esc_attr( $module_id ) ) : '' ),
			( '' !== $module_class ? sprintf( ' %1$s', esc_attr( $module_class ) ) : '' )
		);

		return $output;
	}
}
new Tm_Builder_Module_Toggle;

