<?php
use Elementor\Widget_Base;
use Elementor\Controls_Manager;
use Elementor\Repeater;
use Elementor\Group_Control_Typography;
use Elementor\Group_Control_Border;
use Elementor\Group_Control_Box_Shadow;

if ( ! defined( 'ABSPATH' ) ) exit;

class Geiss_Testimonial_Slider_Widget extends Widget_Base {

    public function get_name() { return 'geiss_testimonial_slider'; }
    public function get_title() { return __( 'Geiss Testimonial Slider', 'geiss' ); }
    public function get_icon() { return 'eicon-testimonial-carousel'; }
    public function get_categories() { return [ 'general' ]; }

    public function get_style_depends() { return [ 'geiss-testimonial' ]; }
    public function get_script_depends() { return [ 'geiss-testimonial' ]; }

    protected function register_controls() {

        /* =========================
         * CONTENT
         * ========================= */
        $this->start_controls_section(
            'section_content',
            [
                'label' => __( 'Content', 'geiss' ),
                'tab'   => Controls_Manager::TAB_CONTENT,
            ]
        );

        $this->add_control(
            'layout_style',
            [
                'label' => __( 'Layout Style', 'geiss' ),
                'type'  => Controls_Manager::SELECT,
                'default' => 'style-1',
                'options' => [
                    'style-1' => __( 'Style 1 (Left)', 'geiss' ),
                    'style-2' => __( 'Style 2 (Centered)', 'geiss' ),
                ],
            ]
        );

        $this->add_control(
            'show_title',
            [
                'label' => __( 'Show Title', 'geiss' ),
                'type'  => Controls_Manager::SWITCHER,
                'default' => 'yes',
            ]
        );

        $repeater = new Repeater();

        $repeater->add_control(
            'item_title',
            [
                'label' => __( 'Title (optional)', 'geiss' ),
                'type'  => Controls_Manager::TEXT,
                'default' => __( 'KUNDENSTIMME', 'geiss' ),
            ]
        );

        $repeater->add_control(
            'desc',
            [
                'label' => __( 'Description / Quote', 'geiss' ),
                'type'  => Controls_Manager::TEXTAREA,
                'rows'  => 5,
                'default' => __( 'Die Holzverarbeitung und der Holzrohstoff sind qualitativ überragend...', 'geiss' ),
            ]
        );

        $repeater->add_control(
            'name',
            [
                'label' => __( 'Name', 'geiss' ),
                'type'  => Controls_Manager::TEXT,
                'default' => __( 'Christian Brunnbauer', 'geiss' ),
            ]
        );

        $repeater->add_control(
            'company',
            [
                'label' => __( 'Company / Position', 'geiss' ),
                'type'  => Controls_Manager::TEXT,
                'default' => __( 'Geschäftsführer – Brunnbauer GmbH & Co. KG', 'geiss' ),
            ]
        );

        $this->add_control(
            'items',
            [
                'label' => __( 'Testimonials', 'geiss' ),
                'type'  => Controls_Manager::REPEATER,
                'fields'=> $repeater->get_controls(),
                'default' => [
                    [
                        'item_title' => 'KUNDENSTIMME',
                        'desc' => 'Die Holzverarbeitung und der Holzrohstoff sind qualitativ überragend. Für uns ist die Zimmerei Geiss die erste Adresse bzgl. eines Dachstuhlbaus.',
                        'name' => 'Christian Brunnbauer',
                        'company' => 'Geschäftsführer – Brunnbauer GmbH & Co. KG',
                    ],
                    [
                        'item_title' => 'KUNDENSTIMME',
                        'desc' => 'Top Zusammenarbeit, schnelle Kommunikation und super Ergebnis. Wir würden jederzeit wieder beauftragen.',
                        'name' => 'Max Mustermann',
                        'company' => 'Projektleiter – Beispiel GmbH',
                    ],
                ],
                'title_field' => '{{{ name }}}',
            ]
        );

        $this->add_control(
            'autoplay',
            [
                'label' => __( 'Autoplay', 'geiss' ),
                'type'  => Controls_Manager::SWITCHER,
                'default' => 'no',
            ]
        );

        $this->add_control(
            'autoplay_delay',
            [
                'label' => __( 'Autoplay Delay (ms)', 'geiss' ),
                'type'  => Controls_Manager::NUMBER,
                'default' => 5000,
                'min' => 1000,
                'step' => 500,
                'condition' => [ 'autoplay' => 'yes' ],
            ]
        );

        $this->add_control(
            'transition_speed',
            [
                'label' => __( 'Transition Speed (ms)', 'geiss' ),
                'type'  => Controls_Manager::NUMBER,
                'default' => 700,
                'min' => 50,
                'step' => 50,
                'description' => __( 'Recommended: 600–900 for smooth sliding', 'geiss' ),
            ]
        );

        $this->end_controls_section();


        /* =========================
         * STYLE: WRAPPER
         * ========================= */
        $this->start_controls_section(
            'section_style_wrapper',
            [
                'label' => __( 'Wrapper', 'geiss' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'max_width',
            [
                'label' => __( 'Max Width', 'geiss' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%', 'vw' ],
                'range' => [
                    'px' => [ 'min' => 300, 'max' => 1400 ],
                    '%'  => [ 'min' => 30,  'max' => 100 ],
                    'vw' => [ 'min' => 30,  'max' => 100 ],
                ],
                'default' => [ 'unit' => 'px', 'size' => 900 ],
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts' => 'max-width: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'wrapper_padding',
            [
                'label' => __( 'Padding', 'geiss' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', 'em', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts' => 'padding: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_control(
            'wrapper_bg',
            [
                'label' => __( 'Background', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Border::get_type(),
            [
                'name' => 'wrapper_border',
                'selector' => '{{WRAPPER}} .geiss-ts',
            ]
        );

        $this->add_responsive_control(
            'wrapper_radius',
            [
                'label' => __( 'Border Radius', 'geiss' ),
                'type' => Controls_Manager::DIMENSIONS,
                'size_units' => [ 'px', '%' ],
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts' => 'border-radius: {{TOP}}{{UNIT}} {{RIGHT}}{{UNIT}} {{BOTTOM}}{{UNIT}} {{LEFT}}{{UNIT}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Box_Shadow::get_type(),
            [
                'name' => 'wrapper_shadow',
                'selector' => '{{WRAPPER}} .geiss-ts',
            ]
        );

        $this->end_controls_section();


        /* =========================
         * STYLE: NAVIGATION (Normal/Hover)
         * ========================= */
        $this->start_controls_section(
            'section_style_nav',
            [
                'label' => __( 'Navigation Buttons', 'geiss' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_responsive_control(
            'nav_size',
            [
                'label' => __( 'Button Size', 'geiss' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px' ],
                'range' => [ 'px' => [ 'min' => 24, 'max' => 90 ] ],
                'default' => [ 'size' => 36, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav' => 'width: {{SIZE}}{{UNIT}}; height: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->add_responsive_control(
            'nav_radius',
            [
                'label' => __( 'Border Radius', 'geiss' ),
                'type' => Controls_Manager::SLIDER,
                'size_units' => [ 'px', '%' ],
                'range' => [
                    'px' => [ 'min' => 0, 'max' => 50 ],
                    '%' => [ 'min' => 0, 'max' => 50 ],
                ],
                'default' => [ 'size' => 8, 'unit' => 'px' ],
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav' => 'border-radius: {{SIZE}}{{UNIT}};',
                ],
            ]
        );

        $this->start_controls_tabs( 'nav_tabs' );

        // NORMAL
        $this->start_controls_tab( 'nav_tab_normal', [ 'label' => __( 'Normal', 'geiss' ) ] );

        $this->add_control(
            'nav_color',
            [
                'label' => __( 'Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_bg',
            [
                'label' => __( 'Background', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_border_color',
            [
                'label' => __( 'Border Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->end_controls_tab();

        // HOVER
        $this->start_controls_tab( 'nav_tab_hover', [ 'label' => __( 'Hover', 'geiss' ) ] );

        $this->add_control(
            'nav_hover_color',
            [
                'label' => __( 'Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav:hover' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_hover_bg',
            [
                'label' => __( 'Background', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav:hover' => 'background-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_hover_border_color',
            [
                'label' => __( 'Border Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav:hover' => 'border-color: {{VALUE}};',
                ],
            ]
        );

        $this->add_control(
            'nav_hover_scale',
            [
                'label' => __( 'Hover Scale', 'geiss' ),
                'type' => Controls_Manager::SLIDER,
                'range' => [
                    'px' => [
                        'min' => 0.9,
                        'max' => 1.2,
                        'step' => 0.01,
                    ],
                ],
                'default' => [ 'size' => 1.05 ],
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__nav:hover' => 'transform: scale({{SIZE}});',
                ],
            ]
        );

        $this->end_controls_tab();

        $this->end_controls_tabs();
        $this->end_controls_section();


        /* =========================
         * STYLE: TITLE
         * ========================= */
        $this->start_controls_section(
            'section_style_title',
            [
                'label' => __( 'Title', 'geiss' ),
                'tab'   => Controls_Manager::TAB_STYLE,
                'condition' => [ 'show_title' => 'yes' ],
            ]
        );

        $this->add_control(
            'title_color',
            [
                'label' => __( 'Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__title' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'title_typo',
                'selector' => '{{WRAPPER}} .geiss-ts__title',
            ]
        );

        $this->end_controls_section();


        /* =========================
         * STYLE: DESCRIPTION
         * ========================= */
        $this->start_controls_section(
            'section_style_desc',
            [
                'label' => __( 'Description / Quote', 'geiss' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'desc_color',
            [
                'label' => __( 'Text Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__desc' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'desc_typo',
                'selector' => '{{WRAPPER}} .geiss-ts__desc',
            ]
        );

        $this->end_controls_section();


        /* =========================
         * STYLE: AUTHOR
         * ========================= */
        $this->start_controls_section(
            'section_style_author',
            [
                'label' => __( 'Author', 'geiss' ),
                'tab'   => Controls_Manager::TAB_STYLE,
            ]
        );

        $this->add_control(
            'name_color',
            [
                'label' => __( 'Name Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__name' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'name_typo',
                'selector' => '{{WRAPPER}} .geiss-ts__name',
            ]
        );

        $this->add_control(
            'company_color',
            [
                'label' => __( 'Company Color', 'geiss' ),
                'type' => Controls_Manager::COLOR,
                'selectors' => [
                    '{{WRAPPER}} .geiss-ts__company' => 'color: {{VALUE}};',
                ],
            ]
        );

        $this->add_group_control(
            Group_Control_Typography::get_type(),
            [
                'name' => 'company_typo',
                'selector' => '{{WRAPPER}} .geiss-ts__company',
            ]
        );

        $this->end_controls_section();
    }

    protected function render() {
        $settings = $this->get_settings_for_display();
        $items = isset($settings['items']) ? $settings['items'] : [];

        if ( empty( $items ) ) return;

        $autoplay = ( isset($settings['autoplay']) && $settings['autoplay'] === 'yes' ) ? 'true' : 'false';
        $delay    = isset($settings['autoplay_delay']) ? (int) $settings['autoplay_delay'] : 5000;
        $speed    = isset($settings['transition_speed']) ? (int) $settings['transition_speed'] : 700;
        ?>
        <div class="geiss-ts <?php echo esc_attr( $settings['layout_style'] ); ?>"
             data-autoplay="<?php echo esc_attr( $autoplay ); ?>"
             data-delay="<?php echo esc_attr( $delay ); ?>"
             style="--geiss-speed: <?php echo esc_attr( max(50, $speed) ); ?>ms;">

            <div class="geiss-ts__nav-wrap" aria-label="Slider Navigation">
                <button class="geiss-ts__nav geiss-ts__prev" type="button" aria-label="Previous">‹</button>
                <button class="geiss-ts__nav geiss-ts__next" type="button" aria-label="Next">›</button>
            </div>

            <div class="geiss-ts__viewport">
                <div class="geiss-ts__track">
                    <?php foreach ( $items as $item ) : ?>
                        <div class="geiss-ts__slide">
                            <?php if ( isset($settings['show_title']) && $settings['show_title'] === 'yes' && ! empty( $item['item_title'] ) ) : ?>
                                <div class="geiss-ts__title"><?php echo esc_html( $item['item_title'] ); ?></div>
                            <?php endif; ?>

                            <?php if ( ! empty( $item['desc'] ) ) : ?>
                                <div class="geiss-ts__desc">“<?php echo esc_html( $item['desc'] ); ?>”</div>
                            <?php endif; ?>

                            <div class="geiss-ts__meta">
                                <?php if ( ! empty( $item['name'] ) ) : ?>
                                    <div class="geiss-ts__name"><?php echo esc_html( $item['name'] ); ?></div>
                                <?php endif; ?>
                                <?php if ( ! empty( $item['company'] ) ) : ?>
                                    <div class="geiss-ts__company"><?php echo esc_html( $item['company'] ); ?></div>
                                <?php endif; ?>
                            </div>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>

        </div>
        <?php
    }
}
