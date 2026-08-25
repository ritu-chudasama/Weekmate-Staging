<?php
/**
 * Template Name: WeekMate vs JIRA
 *
 * @package WordPress
 * @subpackage WeekMate
 * @since WeekMate 1.0
 */

get_header();
$banner_section = get_field('banner_section');
$compare_section = get_field('compare_section');
$details_compare_section = get_field('details_compare_section');
// echo "<pre>";
// print_r($why_to_choose_accordion);
// echo "</pre>";
// exit;
?>
<section class="product-banner-section sectionCvr">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 order-1 order-lg-0">
                <div class="banner-conetnt">
                    <div class="product-badges">
                        <img src="<?php echo esc_url($banner_section['logo']['url']); ?>" alt="<?php echo esc_attr($banner_section['logo']['name']); ?>" class="img-fluid">
                        <p class="logo-text"><?php echo esc_html($banner_section['logo_text']); ?></p>
                    </div>
                    <h1 class="banner-title"><?php echo esc_html($banner_section['heading']); ?></h1>
                    <p class="banner-subtitle"><?php echo esc_html($banner_section['description']); ?></p>

                    <div class="ratings-logo-wrap">
                        <?php foreach( $banner_section['ratings_logo'] as $row ): ?>
                            <?php if( !empty($row['logo']) ): ?>
                                <div class="img-wrapper">
                                    <img src="<?php echo esc_url($row['logo']['url']); ?>" alt="<?php echo esc_attr($row['logo']['alt']); ?>" class="img-fluid">
                                </div>
                            <?php endif; ?>
                        <?php endforeach; ?>
                    </div>
                    <a href="<?php echo esc_url($banner_section['button']['url']); ?>" class="btn theme-btn"><?php echo esc_html($banner_section['button']['title']); ?></a>
                </div>
            </div>
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12 pb-lg-0 pb-4">
                <img src="<?php echo esc_url($banner_section['image']['url']); ?>" alt="<?php echo esc_attr($banner_section['image']['name']); ?>" class="img-fluid">
            </div>
        </div>
    </div>
</section>

<section class="compare-section">
    <div class="container">
        <div class="row gy-4">
            <?php foreach( $compare_section['compare_items'] as $item ): ?>
		        <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12">
                    <div class="compare-box">
                        <!-- Logo -->
                        <?php if( !empty($item['logo']) ): ?>
                            <div class="compare-logo">
                                <img src="<?php echo esc_url($item['logo']['url']); ?>" 
                                        alt="<?php echo esc_attr($item['logo']['alt']); ?>" 
                                        class="img-fluid">
                            </div>
                        <?php endif; ?>

                        <!-- Description -->
                        <?php if( !empty($item['descraption']) ): ?>
                            <p class="compare-description">
                                <?php echo esc_html($item['descraption']); ?>
                            </p>
                        <?php endif; ?>

                        <!-- Accordion -->
                        <?php if( !empty($item['accordion']) ): ?>
                            <div class="compare-accordion">
                                <?php foreach( $item['accordion'] as $i => $acc ): ?>
                                    <div class="accordion-item">
                                        <h3 class="accordion-title">
                                            <?php echo esc_html($acc['title']); ?>
                                        </h3>
                                        <div class="accordion-content">
                                            <p><?php echo esc_html($acc['content']); ?></p>
                                        </div>
                                    </div>
                                <?php endforeach; ?>
                            </div>
                        <?php endif; ?>
                    </div>
		        </div>
            <?php endforeach; ?>
		</div>

    </div>
</section>

<section class="details_compare_section sectionCvr">
    <div class="container">
        <div class="section-header text-center">
            <p class="sub-heading"><?php echo esc_html($details_compare_section['sub_heading']); ?></p>
            <h2 class="heading h1"><?php echo esc_html($details_compare_section['heading']); ?></h2>
            <p class="description"><?php echo esc_html($details_compare_section['description']); ?></p>
        </div>
        <div class="row">
            <!-- Feature Column -->
            <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-6 col-sm-12 compare-col">
                <div class="compare-features">
                    <div class="img-wrapper"></div>
                    <?php foreach( $details_compare_section['details_compare_repeater'] as $item ): ?>
                        <div class="feature-item">
                            <p><?php echo esc_html($item['text']); ?></p>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- WeekMate Column -->
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 compare-sign">
                <div class="compare-weekmate text-center">
                    <div class="img-wrapper">
                        <img src="https://weekmate.in/wp-content/uploads/2025/08/Mask-group-1.png" width="225px" height="86px" alt="weekmate-img" />
                    </div>
                    <?php foreach( $details_compare_section['details_compare_repeater'] as $item ): ?>
                        <div class="compare-value">
                            <?php if( $item['weekmate'] === 'yes' ): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                            <path d="M14.5 29C22.509 29 29 22.509 29 14.5C29 6.49102 22.509 0 14.5 0C6.49102 0 0 6.49102 0 14.5C0 22.509 6.49102 29 14.5 29ZM19.2805 12.0475L14.7492 19.2975C14.5113 19.677 14.1035 19.9148 13.6561 19.9375C13.2086 19.9602 12.7781 19.7563 12.5119 19.3937L9.79316 15.7687C9.34004 15.1684 9.46465 14.3187 10.065 13.8656C10.6654 13.4125 11.515 13.5371 11.9682 14.1375L13.4975 16.1766L16.9752 10.6088C17.3717 9.97441 18.21 9.77617 18.85 10.1783C19.49 10.5805 19.6826 11.4131 19.2805 12.0531V12.0475Z" fill="#1A8200"/>
                            </svg>
                            <?php elseif( $item['weekmate'] === 'no' ): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                                    <path d="M14.5 29C22.509 29 29 22.509 29 14.5C29 6.49102 22.509 0 14.5 0C6.49102 0 0 6.49102 0 14.5C0 22.509 6.49102 29 14.5 29ZM9.45898 9.45898C9.99141 8.92656 10.8523 8.92656 11.3791 9.45898L14.4943 12.5742L17.6096 9.45898C18.142 8.92656 19.0029 8.92656 19.5297 9.45898C20.0564 9.99141 20.0621 10.8523 19.5297 11.3791L16.4145 14.4943L19.5297 17.6096C20.0621 18.142 20.0621 19.0029 19.5297 19.5297C18.9973 20.0564 18.1363 20.0621 17.6096 19.5297L14.4943 16.4145L11.3791 19.5297C10.8467 20.0621 9.98574 20.0621 9.45898 19.5297C8.93223 18.9973 8.92656 18.1363 9.45898 17.6096L12.5742 14.4943L9.45898 11.3791C8.92656 10.8467 8.92656 9.98574 9.45898 9.45898Z" fill="#FF0000"/>
                                </svg>
                            <?php endif; ?>

                            <?php if( !empty($item['weekmatetext']) ): ?>
                                <span><?php echo esc_html($item['weekmatetext']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
            <!-- Jira Column -->
            <div class="col-xxl-3 col-xl-3 col-lg-3 col-md-3 col-sm-12 compare-sign">
                <div class="compare-jira text-center">
                    <div class="img-wrapper">
                        <img src="https://weekmate.in/wp-content/uploads/2025/08/Mask-group.png" width="153px" height="86px" alt="weekmate-img" />
                    </div>
                    <?php if( !empty($details_compare_section['jira_logo']) ): ?>
                        <div class="logo mb-3">
                            <img src="<?php echo esc_url($details_compare_section['jira_logo']['url']); ?>" 
                                 alt="<?php echo esc_attr($details_compare_section['jira_logo']['alt']); ?>" 
                                 class="img-fluid">
                        </div>
                    <?php endif; ?>
                    <?php foreach( $details_compare_section['details_compare_repeater'] as $item ): ?>
                        <div class="compare-value">
                            <?php if( $item['jira'] === 'yes' ): ?>
                               <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                                 <path d="M14.5 29C22.509 29 29 22.509 29 14.5C29 6.49102 22.509 0 14.5 0C6.49102 0 0 6.49102 0 14.5C0 22.509 6.49102 29 14.5 29ZM19.2805 12.0475L14.7492 19.2975C14.5113 19.677 14.1035 19.9148 13.6561 19.9375C13.2086 19.9602 12.7781 19.7563 12.5119 19.3937L9.79316 15.7687C9.34004 15.1684 9.46465 14.3187 10.065 13.8656C10.6654 13.4125 11.515 13.5371 11.9682 14.1375L13.4975 16.1766L16.9752 10.6088C17.3717 9.97441 18.21 9.77617 18.85 10.1783C19.49 10.5805 19.6826 11.4131 19.2805 12.0531V12.0475Z" fill="#1A8200"/>
                                </svg>
                            <?php elseif( $item['jira'] === 'no' ): ?>
                                <svg xmlns="http://www.w3.org/2000/svg" width="29" height="29" viewBox="0 0 29 29" fill="none">
                                  <path d="M14.5 29C22.509 29 29 22.509 29 14.5C29 6.49102 22.509 0 14.5 0C6.49102 0 0 6.49102 0 14.5C0 22.509 6.49102 29 14.5 29ZM9.45898 9.45898C9.99141 8.92656 10.8523 8.92656 11.3791 9.45898L14.4943 12.5742L17.6096 9.45898C18.142 8.92656 19.0029 8.92656 19.5297 9.45898C20.0564 9.99141 20.0621 10.8523 19.5297 11.3791L16.4145 14.4943L19.5297 17.6096C20.0621 18.142 20.0621 19.0029 19.5297 19.5297C18.9973 20.0564 18.1363 20.0621 17.6096 19.5297L14.4943 16.4145L11.3791 19.5297C10.8467 20.0621 9.98574 20.0621 9.45898 19.5297C8.93223 18.9973 8.92656 18.1363 9.45898 17.6096L12.5742 14.4943L9.45898 11.3791C8.92656 10.8467 8.92656 9.98574 9.45898 9.45898Z" fill="#FF0000"/>
                                </svg>
                            <?php endif; ?>

                            <?php if( !empty($item['jiratext']) ): ?>
                                <span><?php echo esc_html($item['jiratext']); ?></span>
                            <?php endif; ?>
                        </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div> 
    </div>
</section>
<?php

get_footer();