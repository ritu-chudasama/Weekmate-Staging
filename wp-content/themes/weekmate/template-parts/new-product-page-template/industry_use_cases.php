<?php
/**
 * Section: Industry Use-cases
 * Layout: industry_use_cases
 * Note: NEW section - has own CSS and JS
 */

$heading       = get_sub_field('heading');
$industry_tabs = get_sub_field('industry_tabs');
?>

<?php if ( ! empty($industry_tabs) ) : ?>
<section class="industry-use-cases-sec sectionCvr">
    <div class="container">
        <div class="row section-header text-center">
            <div class="col-xxl-12">
                <?php if ( $heading ) : ?>
                <h2 class="h1 heading-bold text-none"><?php echo esc_html($heading); ?></h2>
                <?php endif; ?>
            </div>
        </div>
        <div class="row">
            <div class="col-xxl-12">
                <div class="use-case-tabs-wrapper">
                    <?php foreach ( $industry_tabs as $key => $tab ) : ?>
                    <button class="use-case-tab-btn <?php echo ( $key == 0 ) ? 'active' : ''; ?>"
                            data-tab="use_case_<?php echo $key; ?>">
                        <?php echo esc_html($tab['tab_label']); ?>
                    </button>
                    <?php endforeach; ?>
                </div>
                <!-- Mobile Dropdown -->
                <div class="use-case-custom-dropdown">
                    <div class="use-case-dropdown-selected">
                        <span><?php echo esc_html($industry_tabs[0]['tab_label']); ?></span>
                        <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg" width="14" height="14">
                            <path d="M2 4L6 8L10 4" stroke="#333" stroke-width="1.5" stroke-linecap="round"/>
                        </svg>
                    </div>
                    <ul class="use-case-dropdown-list">
                        <?php foreach ( $industry_tabs as $key => $tab ) : ?>
                        <li class="use-case-dropdown-item <?php echo ($key == 0) ? 'active' : ''; ?>"
                            data-tab="use_case_<?php echo $key; ?>">
                            <?php echo esc_html($tab['tab_label']); ?>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>
        </div>
        <?php foreach ( $industry_tabs as $key => $tab ) : ?>
        <div class="use-case-tab-content <?php echo ( $key == 0 ) ? 'active' : ''; ?>"
             id="use_case_<?php echo $key; ?>">
            <div class="row align-items-center">
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <?php if ( ! empty($tab['description']) ) : ?>
                    <p class="tab-description"><?php echo esc_html($tab['description']); ?></p>
                    <?php endif; ?>
                    <?php if ( ! empty($tab['bullet_points']) ) : ?>
                    <ul class="bullet-list">
                        <?php foreach ( $tab['bullet_points'] as $bullet ) : ?>
                        <li>
                            <span class="bullet-icon">
                                <svg viewBox="0 0 12 12" fill="none" xmlns="http://www.w3.org/2000/svg">
                                    <path d="M2 6L5 9L10 3" stroke="white" stroke-width="1.5" stroke-linecap="round" stroke-linejoin="round"/>
                                </svg>
                            </span>
                            <span class="bullet-text">
                                <strong><?php echo esc_html($bullet['title']); ?></strong>
                                <span><?php echo esc_html($bullet['description']); ?></span>
                            </span>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                    <?php endif; ?>
                </div>
                <div class="col-xxl-6 col-xl-6 col-lg-6 col-md-12 col-sm-12">
                    <div class="tab-image-wrapper">
                        <?php if ( ! empty($tab['image']['url']) ) : ?>
                        <img src="<?php echo esc_url($tab['image']['url']); ?>"
                            alt="<?php echo esc_attr($tab['image']['alt']); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
        <?php endforeach; ?>
    </div>
</section>
<?php endif; ?>

<script>
(function() {
    // Tab buttons - desktop
    var tabBtns = document.querySelectorAll('.use-case-tab-btn');
    tabBtns.forEach(function(btn) {
        btn.addEventListener('click', function() {
            var target = this.getAttribute('data-tab');
            tabBtns.forEach(function(b) { b.classList.remove('active'); });
            document.querySelectorAll('.use-case-tab-content').forEach(function(c) { c.classList.remove('active'); });
            this.classList.add('active');
            document.getElementById(target).classList.add('active');
        });
    });

    // Custom dropdown - mobile
    var dropdown = document.querySelector('.use-case-custom-dropdown');
    if ( dropdown ) {
        var selected = dropdown.querySelector('.use-case-dropdown-selected');
        var items = dropdown.querySelectorAll('.use-case-dropdown-item');

        selected.addEventListener('click', function() {
            dropdown.classList.toggle('open');
        });

        document.addEventListener('click', function(e) {
            if ( ! dropdown.contains(e.target) ) {
                dropdown.classList.remove('open');
            }
        });

        items.forEach(function(item) {
            item.addEventListener('click', function() {
                var target = this.getAttribute('data-tab');
                var label = this.textContent.trim();

                dropdown.querySelector('.use-case-dropdown-selected span').textContent = label;
                items.forEach(function(i) { i.classList.remove('active'); });
                this.classList.add('active');

                document.querySelectorAll('.use-case-tab-content').forEach(function(c) { c.classList.remove('active'); });
                document.getElementById(target).classList.add('active');

                dropdown.classList.remove('open');
            });
        });
    }
})();
</script>