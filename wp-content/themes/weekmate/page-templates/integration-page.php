<?php
/**
 * Template Name: Integration Page
 *
 * @package WordPress
 * @subpackage WeekMate
 */

get_header();

$hero    = get_field('integration_hero');
$feature = get_field('integration_feature_block');
$listing = get_field('integration_listing');
?>

<?php if ($hero) : ?>
<!-- ══════════════════════════════════════════
     HERO SECTION
══════════════════════════════════════════ -->
<section class="intg-hero">
    <div class="container">
        <div class="row align-items-center">
            <div class="col-lg-6">
                <div class="intg-hero__content">
                    <?php if (!empty($hero['label'])) : ?>
                        <span class="intg-hero__label"><?php echo esc_html($hero['label']); ?></span>
                    <?php endif; ?>

                    <h1 class="intg-hero__heading">
                        <?php if (!empty($hero['heading'])) : ?>
                            <?php echo esc_html($hero['heading']); ?>
                        <?php endif; ?>
                        <?php if (!empty($hero['heading_highlight'])) : ?>
                            <span class="intg-hero__heading-highlight"><?php echo esc_html($hero['heading_highlight']); ?></span>
                        <?php endif; ?>
                        <?php if (!empty($hero['heading_suffix'])) : ?>
                            <?php echo esc_html($hero['heading_suffix']); ?>
                        <?php endif; ?>
                    </h1>

                    <?php if (!empty($hero['description'])) : ?>
                        <p class="intg-hero__desc"><?php echo esc_html($hero['description']); ?></p>
                    <?php endif; ?>

                    <?php if (!empty($hero['button'])) : ?>
                        <div class="intg-hero__cta">
                            <a href="<?php echo esc_url($hero['button']['url']); ?>"
                               class="intg-hero__btn"
                               target="<?php echo esc_attr($hero['button']['target'] ?: '_self'); ?>">
                                <?php echo esc_html($hero['button']['title']); ?>
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <div class="col-lg-6">
                <div class="intg-hero__image">
                    <?php if (!empty($hero['phone_image'])) : ?>
                        <img src="<?php echo esc_url($hero['phone_image']['url']); ?>"
                             alt="<?php echo esc_attr($hero['phone_image']['alt']); ?>">
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if ($feature) : ?>
<!-- ══════════════════════════════════════════
     FEATURE BLOCK
══════════════════════════════════════════ -->
<section class="intg-feature">
    <div class="container">
        <div class="intg-feature__card">
            <div class="row align-items-center">
                <div class="col-lg-6">
                    <div class="intg-feature__content">
                        <h2 class="intg-feature__heading">
                            <?php if (!empty($feature['heading'])) : ?>
                                <?php echo esc_html($feature['heading']); ?>
                            <?php endif; ?>
                            <?php if (!empty($feature['heading_highlight'])) : ?>
                                <span class="intg-feature__heading-highlight"><?php echo esc_html($feature['heading_highlight']); ?></span>
                            <?php endif; ?>
                        </h2>
                        <?php if (!empty($feature['description'])) : ?>
                            <p class="intg-feature__desc"><?php echo esc_html($feature['description']); ?></p>
                        <?php endif; ?>
                    </div>
                </div>
                <div class="col-lg-6">
                    <div class="intg-feature__image">
                        <?php if (!empty($feature['logos_image'])) : ?>
                            <img src="<?php echo esc_url($feature['logos_image']['url']); ?>"
                                 alt="<?php echo esc_attr($feature['logos_image']['alt']); ?>">
                        <?php endif; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endif; ?>


<?php if ($listing) : ?>
<!-- ══════════════════════════════════════════
     INTEGRATIONS LISTING
══════════════════════════════════════════ -->
<section class="intg-listing">
    <div class="container">

        <!-- Heading -->
        <div class="intg-listing__header">
            <?php if (!empty($listing['heading'])) : ?>
                <h2 class="intg-listing__heading"><?php echo esc_html($listing['heading']); ?></h2>
            <?php endif; ?>
            <?php if (!empty($listing['sub_heading'])) : ?>
                <p class="intg-listing__sub-heading"><?php echo esc_html($listing['sub_heading']); ?></p>
            <?php endif; ?>
        </div>

        <!-- Search Bar -->
        <div class="intg-listing__search">
            <div class="intg-search">
                <input type="text"
                       id="intg-search-input"
                       class="intg-search__input"
                       placeholder="<?php echo esc_attr($listing['search_placeholder'] ?: 'Search Integrations...'); ?>">
                <button class="intg-search__btn" aria-label="Search">
                    <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 16 16" fill="none">
                        <path d="M12.9981 6.49905C12.9981 7.93321 12.5325 9.25802 11.7483 10.3329L15.7039 14.2917C16.0945 14.6822 16.0945 15.3165 15.7039 15.7071C15.3134 16.0976 14.6791 16.0976 14.2885 15.7071L10.3329 11.7483C9.25802 12.5325 7.93321 12.9981 6.49905 12.9981C2.90895 12.9981 0 10.0891 0 6.49905C0 2.90895 2.90895 0 6.49905 0C10.0891 0 12.9981 2.90895 12.9981 6.49905ZM6.49905 10.9984C8.98306 10.9984 10.9984 8.98306 10.9984 6.49905C10.9984 4.01504 8.98306 1.99971 6.49905 1.99971C4.01504 1.99971 1.99971 4.01504 1.99971 6.49905C1.99971 8.98306 4.01504 10.9984 6.49905 10.9984Z" fill="#888"/>
                    </svg>
                </button>
            </div>
        </div>

        <!-- Categories & Cards -->
        <div class="intg-listing__body" id="intg-listing-body">
            <?php if (!empty($listing['integration_categories'])) : ?>
                <?php foreach ($listing['integration_categories'] as $category) : ?>
                    <div class="intg-category" data-category="<?php echo esc_attr(strtolower($category['category_title'])); ?>">

                        <?php if (!empty($category['category_title'])) : ?>
                            <h3 class="intg-category__title"><?php echo esc_html($category['category_title']); ?></h3>
                        <?php endif; ?>

                        <div class="intg-category__grid">
                            <?php foreach ($category['integrations'] as $item) : 
                                $has_link = !empty($item['link']) && !empty($item['link']['url']);
                                $tag      = $has_link ? 'a' : 'div';
                            ?>
                                <<?php echo $tag; ?> class="intg-card"
                                    <?php if ($has_link) : ?>
                                        href="<?php echo esc_url($item['link']['url']); ?>"
                                        target="<?php echo esc_attr($item['link']['target'] ?: '_self'); ?>"
                                    <?php endif; ?>
                                    data-name="<?php echo esc_attr(strtolower($item['name'])); ?>"
                                    data-tag="<?php echo esc_attr(strtolower($item['tag'])); ?>">
                                    <div class="intg-card__icon">
                                        <?php if (!empty($item['icon'])) : ?>
                                            <img src="<?php echo esc_url($item['icon']['url']); ?>"
                                                alt="<?php echo esc_attr($item['icon']['alt'] ?: $item['name']); ?>">
                                        <?php endif; ?>
                                    </div>
                                    <p class="intg-card__name"><?php echo esc_html($item['name']); ?></p>
                                    <?php if (!empty($item['tag'])) : ?>
                                        <p class="intg-card__tag"><?php echo esc_html($item['tag']); ?></p>
                                    <?php endif; ?>
                                </<?php echo $tag; ?>>
                            <?php endforeach; ?>
                        </div>

                    </div>
                <?php endforeach; ?>
            <?php endif; ?>

            <!-- No results message -->
            <p class="intg-listing__no-results" id="intg-no-results" style="display:none;">
                No integrations found.
            </p>
        </div>

    </div>
</section>
<?php endif; ?>

<?php get_footer(); ?>