<?php
/**
 * Template Name: Ai Content Integration
 *
 * CSS:    themes/weekmate/css/city-page-styles.css  (enqueued via weekmate_scripts)
 * JS:     themes/weekmate/js/city-page-hydrate.js   (enqueued via weekmate_scripts)
 * Images: themes/weekmate/images/
 * Logic:  themes/weekmate/functions/city-page-functions.php
 *
 * @package WeekMate
 */

defined( 'ABSPATH' ) || exit;

[ $data, $city, $state, $page_type, $img ] = wmcp_theme_bootstrap_city_page();

get_header();
?>

<div class="homepage wmcp-city-page">

  <!-- ============== HERO ============== -->
  <section class="homepage__hero" id="hero" aria-label="Hero">
    <div class="homepage__hero-background"></div>
    <div class="homepage__hero-container">
      <div class="homepage__hero-content">
        <h1 class="homepage__hero-title title-block-wrapper title-block text-center"  data-field="meta.h1">—</h1>
        <p class="desc" data-field="meta.meta_description">—</p>
        <div class="homepage__hero-buttons">
          <a href="https://app.weekmate.in/register-company" class=" theme-btn mt-0">Sign Up for Free</a>
          <a href="<?php echo esc_url( home_url( '/pricing/' ) ); ?>" class="homepage__btn homepage__btn--secondary">View pricing</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ============== TRUST BAR ============== -->
  <section class="certificate-sec wmcp-trust-bar" aria-label="Certifications">
    <div class="container">
      <div class="certificate-wrapper">
        <div class="row align-items-center justify-content-between">
          <div class="col-xxl-4 col-xl-4 col-lg-4 col-md-12 col-sm-12">
            <div class="certificate-title wmcp-trust-brand">
              <img src="<?php echo esc_url( $img ); ?>/WeekMate Logo - Transparent - High Resolution 2.png" alt="WeekMate" class="wmcp-trust-logo-icon" width="62" height="62" />
              <p class="wmcp-trust-text">Certified To Deliver.<br />Trusted To Lead.</p>
            </div>
          </div>
          <div class="col-xxl-2 col-xl-2 col-lg-2 col-md-12 col-sm-12">
            <span class="seprator wmcp-trust-divider" aria-hidden="true">
              <svg xmlns="http://www.w3.org/2000/svg" width="120" height="6" viewBox="0 0 120 6" fill="none">
                <path d="M120 2.88671L115 -4.2717e-05L115 5.77346L120 2.88671ZM0 2.88672L4.37114e-08 3.38672L115.5 3.38671L115.5 2.88671L115.5 2.38671L-4.37114e-08 2.38672L0 2.88672Z" fill="black"/>
              </svg>
            </span>
          </div>
          <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
            <div class="certificate-lists wmcp-trust-badges">
              <ul class="certificates">
                <li class="wmcp-badge"><img loading="lazy" src="<?php echo esc_url( $img ); ?>/sky-enterprice-ready.png" alt="Skyhigh Enterprise Ready" /></li>
                <li class="wmcp-badge"><img loading="lazy" src="<?php echo esc_url( $img ); ?>/gdpr-ready-366x366 1.png" alt="GDPR compliant" /></li>
                <li class="wmcp-badge"><img loading="lazy" src="<?php echo esc_url( $img ); ?>/AICPA-Logo 1.png" alt="AICPA SOC" /></li>
                <li class="wmcp-badge"><img loading="lazy" src="<?php echo esc_url( $img ); ?>/iso-27001-2013-certification-service-500x500 1.png" alt="ISO 27001" /></li>
              </ul>
            </div>
          </div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============== HR SOLUTIONS / INTRODUCTION ============== -->
  <section class="homepage__hr-solutions" id="wmcp-about">
    <div class="container">
      <div class="homepage__hr-solutions-content">

        <div class="homepage__business-left">
          <div class="homepage__business-header">
            <h2 class="homepage__business-title-main title-block" data-field="sections.introduction.h2">—</h2>
            <p class="desc " data-field="sections.introduction.h3">—</p>
          </div>

          <div class="homepage__business-text-content">
            <?php
            $intro_body = $data['sections']['introduction']['body'] ?? '';
            if ( is_array( $intro_body ) ) {
              foreach ( $intro_body as $para ) {
                $para = trim( $para );
                if ( '' !== $para ) {
                  echo '<p>' . esc_html( $para ) . '</p>';
                }
              }
            } elseif ( '' !== trim( $intro_body ) ) {
              foreach ( array_filter( array_map( 'trim', explode( "\n\n", $intro_body ) ) ) as $para ) {
                echo '<p>' . esc_html( $para ) . '</p>';
              }
            } else {
              echo '<p data-field="sections.introduction.body">—</p>';
            }
            ?>
          </div>
        </div>

        <div class="homepage__business-right">
          <?php
          $wmcp_city_img_url = '';
          $trigger_page_id   = wmcp_get_trigger_page_id( $page_type );

          // Look for the city-specific image in the allowed cities repeater.
          if ( $trigger_page_id && function_exists( 'get_field' ) ) {
              $allowed_rows = get_field( 'wmcp_allowed_cities', $trigger_page_id );

              if ( is_array( $allowed_rows ) ) {
                  foreach ( $allowed_rows as $row ) {
                      if ( sanitize_title( $row['city_name'] ?? '' ) === sanitize_title( $city ) ) {
                          $wmcp_city_img_url = $row['city_image']['url'] ?? '';
                          break;
                      }
                  }
              }
          }

          // Fallback to trigger page featured image if no city image found.
          if ( empty( $wmcp_city_img_url ) && $trigger_page_id ) {
              $wmcp_city_img_url = get_the_post_thumbnail_url( $trigger_page_id, 'large' ) ?: '';
          }

          if ( ! empty( $wmcp_city_img_url ) ) : ?>
              <div class="homepage__city-image-wrap">
                  <img
                      src="<?php echo esc_url( $wmcp_city_img_url ); ?>"
                      alt="<?php echo esc_attr( $city ); ?>"
                      class="homepage__city-img"
                      loading="lazy"
                  />
              </div>
          <?php endif; ?>
      </div>

      </div>
    </div>
  </section>

  <!-- ============== PLACES / BUSINESS AREAS ============== -->
  <section class="homepage__business-areas" style="background-image:url('<?php echo esc_url( $img ); ?>/places-background.png');background-repeat:no-repeat;background-position:center bottom;background-size:cover;">
    <div class="container">
      <div class="title-block-wrapper title-block text-center ">
        <h2 class="title-block" data-field="sections.places.h2">—</h2>
        <p data-field="sections.places.h3">—</p>
      </div>
      <div class="homepage__business-grid" data-list="places"></div>
    </div>
  </section>

  <!-- ============== CHALLENGES & SOLUTIONS ============== -->
  <section class="homepage__challenges">
    <div class="container">
      <div class="homepage__challenges-header">
        <h2 class="title-block-wrapper title-block text-center" data-field="sections.pain_points.h2">—</h2>
        <p class="homepage__challenges-description" data-field="sections.pain_points.h3">—</p>
      </div>

      <div class="homepage__challenges-panels">
        <!-- Left Panel - Pain Points -->
        <div class="homepage__challenges-panel homepage__challenges-panel--pain">
          <div class="homepage__challenges-panel-header">
            <h3 class="homepage__challenges-panel-title" data-text="Pain Points">Pain Points</h3>
          </div>
          <div class="homepage__challenges-rows" data-list="pain"></div>
        </div>

        <!-- Right Panel - Solutions -->
        <div class="homepage__challenges-panel homepage__challenges-panel--solution">
          <div class="homepage__challenges-panel-header">
            <h3 class="homepage__challenges-panel-title" data-text="Solutions">Solutions</h3>
          </div>
          <div class="homepage__challenges-rows" data-list="fix"></div>
        </div>
      </div>
    </div>
  </section>

  <!-- ============== CTA BANNER ============== -->

  <?php
  $cta_rows = function_exists('get_field') ? get_field('cta', $trigger_page_id) : array();
  $cta_row  = ! empty($cta_rows[0]) ? $cta_rows[0] : array();
  $cta_heading    = $cta_row['cta_heading']       ?? 'See WeekMate HRMS in action';
  $cta_subheading = $cta_row['cta_subheading']    ?? 'Book a 20-minute walkthrough and run your first payroll cycle on us.';
  $cta_button     = $cta_row['cta_button']        ?? array();
  $cta_image      = $cta_row['cta_overlay_image'] ?? array();
  $cta_btn_url    = ! empty($cta_button['url'])   ? $cta_button['url']   : home_url('/contact-us/');
  $cta_btn_text   = ! empty($cta_button['title']) ? $cta_button['title'] : 'Book A Demo';
  $cta_img_url    = '';
  if ( ! empty($cta_image) ) {
      $cta_img_url = is_array($cta_image) ? ($cta_image['url'] ?? '') : (string) $cta_image;
  }
  if ( empty($cta_img_url) ) {
      $cta_img_url = esc_url( $img ) . '/Group 1437257844.png';
  }
  ?>

  <section class="homepage__cta">
    <div class="container">
      <div class="homepage__cta-wrapper">
        <div class="homepage__cta-illustration-wrapper">
          <img class="homepage__cta-illustration" src="<?php echo esc_url( $cta_img_url ); ?>" alt="Person working on laptop" loading="lazy" />
        </div>
        <div class="homepage__cta-content">
          <h2 class="homepage__cta-title"><?php echo esc_html( $cta_heading ); ?></h2>
          <p class="homepage__cta-subtitle"><?php echo esc_html( $cta_subheading ); ?></p>
          <a href="<?php echo esc_url( $cta_btn_url ); ?>" class="homepage__btn homepage__btn--primary homepage__btn--cta">Book a Demo</a>
        </div>
      </div>
    </div>
  </section>

  <!-- ============== FAQ (Bootstrap accordion — unchanged) ============== -->
  <section class="sectionCvr faq-section">
    <div class="container">
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="row justify-content-between align-items-center">
                    <div class="col-xxl-5 col-xl-6 col-lg-6 col-md-9 col-sm-12">
                        <div class="title-block-wrapper title-block pb-0 mb-0">
                            <h2 class="title title-block">Have Questions? We've Got Answers.</h2>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-10 col-xl-10 col-lg-11 col-md-12 col-sm-12 me-auto ms-auto">
                <div class="faq-qa-wrapper">
                    <div class="row">
                        <div class="row" id="wmcpFaqMain" data-list="faqs"></div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

</div><!-- .homepage.wmcp-city-page -->


<script id="page-data" type="application/json"><?php echo wp_json_encode( $data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES ); ?></script>

<?php
get_footer();
exit;