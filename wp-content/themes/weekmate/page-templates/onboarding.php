<?php
/**
 * Template Name: Onboarding Page Template
 * Description: Onboarding journey page template with hero, journey steps, and CTA sections
 */

get_header(); ?>

<main class="onboarding-page">
    
    <?php
    // Hero Section
    $hero = get_field('onboarding_hero');
    if ($hero): ?>
        <section class="onboarding-hero">
            <div class="onboarding-hero__container">
                <div class="onboarding-hero__content">
                    <div class="onboarding-hero__text">
                        <?php if (!empty($hero['title'])): ?>
                            <h1 class="onboarding-hero__title"><?php echo esc_html($hero['title']); ?></h1>
                        <?php endif; ?>
                        
                        <?php if (!empty($hero['subtitle'])): ?>
                            <h2 class="onboarding-hero__subtitle"><?php echo esc_html($hero['subtitle']); ?></h2>
                        <?php endif; ?>
                        
                        <?php if (!empty($hero['description'])): ?>
                            <div class="onboarding-hero__description">
                                <?php echo wp_kses_post(wpautop($hero['description'])); ?>
                            </div>
                        <?php endif; ?>
                    </div>
                    
                    <?php if (!empty($hero['image'])): ?>
                        <div class="onboarding-hero__image">
                            <img 
                                src="<?php echo esc_url($hero['image']['url']); ?>" 
                                alt="<?php echo esc_attr($hero['image']['alt'] ?: 'Hero Image'); ?>"
                                class="onboarding-hero__img"
                            >
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <?php
    // Journey Section
    $journey = get_field('onboarding_journey');
    if ($journey && !empty($journey['steps'])): ?>
        <section class="onboarding-journey">
            <div class="onboarding-journey__container">
                <?php if (!empty($journey['title'])): ?>
                    <h2 class="onboarding-journey__title"><?php echo esc_html($journey['title']); ?></h2>
                <?php endif; ?>
                
                <div class="onboarding-journey__steps">
                    <?php 
                    $steps = $journey['steps'];
                    $number_bg = !empty($journey['number_bg_image']) ? $journey['number_bg_image'] : '';
                    
                    foreach ($steps as $index => $step): 
                        $step_number = $index + 1;
                        $is_reverse = ($step_number % 2 == 0);
                        $modifier_class = $is_reverse ? 'onboarding-journey__step--reverse' : '';
                    ?>
                        <div class="onboarding-journey__step <?php echo esc_attr($modifier_class); ?>">
                            <div class="onboarding-journey__step-content">
                                <div class="onboarding-journey__step-number-wrapper">
                                    <div class="onboarding-journey__step-number-wrapper-title-container">
                                    <span 
                                        class="onboarding-journey__step-number"
                                        <?php if ($number_bg): ?>
                                            style="background-image: url('<?php echo esc_url($number_bg); ?>');"
                                        <?php endif; ?>
                                    >
                                        #<?php echo $step_number; ?>
                                    </span>
                                    <?php if (!empty($step['title'])): ?>
                                            <h3 class="onboarding-journey__step-title"><?php echo esc_html($step['title']); ?></h3>
                                        <?php endif; ?>
                                    </div>
                                    <div class="onboarding-journey__step-text">
                                        
                                        <?php if (!empty($step['description'])): ?>
                                            <div class="onboarding-journey__step-description">
                                                <?php echo wp_kses_post(wpautop($step['description'])); ?>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                            
                            <?php if (!empty($step['image'])): ?>
                                <div class="onboarding-journey__step-image">
                                    <img 
                                        src="<?php echo esc_url($step['image']['url']); ?>" 
                                        alt="<?php echo esc_attr($step['image']['alt'] ?: $step['title']); ?>"
                                        class="onboarding-journey__step-img"
                                    >
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
    <?php
    // CTA Section from ACF Options Page
    $cta = get_field('onboarding_cta', 'option');

    if ($cta): 
        $bg_style = '';
        if (!empty($cta['bg_image'])) {
            $bg_style = 'style="background-image: url(\'' . esc_url($cta['bg_image']) . '\');"';
        }
    ?>
        <section class="onboarding-cta" <?php echo $bg_style; ?>>
            <div class="onboarding-cta__overlay">
                <div class="onboarding-cta__container">
                    <div class="onboarding-cta__content">
                        
                        <div class="onboarding-cta__text">
                            <?php if (!empty($cta['title'])): ?>
                                <h2 class="onboarding-cta__title">
                                    <?php echo esc_html($cta['title']); ?>
                                </h2>
                            <?php endif; ?>
                            
                            <?php if (!empty($cta['description'])): ?>
                                <div class="onboarding-cta__description">
                                    <?php echo wp_kses_post(wpautop($cta['description'])); ?>
                                </div>
                            <?php endif; ?>
                            
                            <?php if (!empty($cta['button_primary']['text']) || !empty($cta['button_secondary']['text'])): ?>
                                <div class="onboarding-cta__buttons">
                                    
                                    <?php if (!empty($cta['button_primary']['text'])): ?>
                                        <a href="<?php echo esc_url($cta['button_primary']['url']); ?>" 
                                        class="onboarding-cta__button onboarding-cta__button--primary">
                                            <?php echo esc_html($cta['button_primary']['text']); ?>
                                        </a>
                                    <?php endif; ?>
                                    
                                    <?php if (!empty($cta['button_secondary']['text'])): ?>
                                        <a href="<?php echo esc_url($cta['button_secondary']['url']); ?>" 
                                        class="onboarding-cta__button onboarding-cta__button--secondary">
                                            <?php echo esc_html($cta['button_secondary']['text']); ?>
                                        </a>
                                    <?php endif; ?>

                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <?php if (!empty($cta['side_image'])): ?>
                            <div class="onboarding-cta__image">
                                <img 
                                    src="<?php echo esc_url($cta['side_image']['url']); ?>" 
                                    alt="<?php echo esc_attr($cta['side_image']['alt'] ?: 'CTA Image'); ?>"
                                    class="onboarding-cta__img"
                                >
                            </div>
                        <?php endif; ?>

                    </div>
                </div>
            </div>
        </section>
    <?php endif; ?>
    
</main>

<?php get_footer(); ?>