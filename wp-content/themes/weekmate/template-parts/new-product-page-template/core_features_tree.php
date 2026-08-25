<?php
/**
 * Section: Core Features Tree
 * Layout: core_features_tree
 * Note: NEW section - has own CSS
 */

$heading                = get_sub_field('heading');
$subheading             = get_sub_field('subheading');
$center_button_label    = get_sub_field('center_button_label');
$core_features_repeater = get_sub_field('core_features_repeater');
$total                  = ! empty($core_features_repeater) ? count($core_features_repeater) : 0;
?>

<section class="core-features-tree-section sectionCvr cft">
    <div class="container">
        <!-- Header -->
        <div class="cft__header">
            <?php if ( $heading ) : ?>
            <h2 class="cft__title h1 heading-bold text-none"><?php echo esc_html($heading); ?></h2>
            <?php endif; ?>
            <?php if ( $subheading ) : ?>
            <p class="cft__subtitle"><?php echo esc_html($subheading); ?></p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Tree (desktop only) -->
    <?php if ( $center_button_label && ! empty($core_features_repeater) ) : ?>
    <div class="cft__tree-wrapper">

        <!-- Center Button -->
        <span class="cft__center-btn"><?php echo esc_html($center_button_label); ?></span>

        <!-- Stem from button -->
        <div class="cft__stem"></div>

        <!-- Branches + Cards -->
        <div class="cft__branch-row">
            <div class="cft__branch-row-inner">
                <?php foreach ( $core_features_repeater as $feature ) : ?>
                <div class="cft__branch">
                    <div class="cft__branch-top"></div>
                    <div class="cft__branch-stem"></div>
                    <div class="cft__card">
                        <?php if ( ! empty($feature['icon']['url']) ) : ?>
                        <img src="<?php echo esc_url($feature['icon']['url']); ?>"
                            alt="<?php echo esc_attr($feature['icon']['alt']); ?>"
                            class="cft__card-icon">
                        <?php endif; ?>
                        <?php if ( ! empty($feature['title']) ) : ?>
                        <h3 class="cft__card-title"><?php echo esc_html($feature['title']); ?></h3>
                        <?php endif; ?>
                        <?php if ( ! empty($feature['description']) ) : ?>
                        <p class="cft__card-desc"><?php echo esc_html($feature['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>

    </div>
    <?php endif; ?>

    <!-- Mobile fallback grid -->
    <?php if ( ! empty($core_features_repeater) ) : ?>
    <div class="cft__cards-mobile container">
        <?php foreach ( $core_features_repeater as $feature ) : ?>
        <div class="cft__card">
            <?php if ( ! empty($feature['icon']['url']) ) : ?>
            <img src="<?php echo esc_url($feature['icon']['url']); ?>"
                alt="<?php echo esc_attr($feature['icon']['alt']); ?>"
                class="cft__card-icon">
            <?php endif; ?>
            <?php if ( ! empty($feature['title']) ) : ?>
            <h3 class="cft__card-title"><?php echo esc_html($feature['title']); ?></h3>
            <?php endif; ?>
            <?php if ( ! empty($feature['description']) ) : ?>
            <p class="cft__card-desc"><?php echo esc_html($feature['description']); ?></p>
            <?php endif; ?>
        </div>
        <?php endforeach; ?>
    </div>
    <?php endif; ?>

</section>


<!-- Smart Hiring Section -->
 <!-- It is Visible only on the hrms page otherwise not  -->
  <?php if (is_page('hrms-payroll-software')) : ?>
 <section class="smart-hiring-process sectionCvr">
    <div class="container">
   
        <div class="smart-hiring-process-wrap">
         

            <video id="shp-bg-video" class="shp-bg-video" muted loop playsinline preload="none" width="1600" height="900">
                <source data-src="https://weekmate.in/wp-content/uploads/2026/08/smart_hire_v1_1787210937435.mp4" type="video/mp4">
            </video>

            <button class="cta">
                <a href="https://weekmate.in/contact-us/">
                Request Smart Hire</a>
            </button>

        </div>
    </div>
</section>
<?php endif; ?>

<script>
(function(){
    var video = document.getElementById('shp-bg-video');
    if (!video) return;
    var source = video.querySelector('source');
    var loaded = false;

    function loadVideo(){
        if (loaded) return;
        loaded = true;
        source.src = source.getAttribute('data-src');
        video.load();
        video.play().catch(function(){});
    }

    if ('IntersectionObserver' in window) {
        var observer = new IntersectionObserver(function(entries){
            entries.forEach(function(entry){
                if (entry.isIntersecting) {
                    loadVideo();
                    observer.disconnect();
                }
            });
        }, { rootMargin: '200px' });
        observer.observe(video);
    } else {
        loadVideo();
    }
})();
</script>
  