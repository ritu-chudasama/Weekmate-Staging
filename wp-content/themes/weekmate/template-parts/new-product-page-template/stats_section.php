<?php
/**
 * Section: Stats
 * Layout: stats_section
 * 
 */

$stats_repeater = get_sub_field('stats_repeater', 'option');
?>

<?php if ( ! empty($stats_repeater) ) : ?>
<section class="stats-section">
    <div class="container">
        <div class="stats-wrapper">
            <?php foreach ( $stats_repeater as $stat ) : ?>
            <div class="stat-item">
                <p class="stat-number"><?php echo esc_html($stat['number']); ?></p>
                <p class="stat-label"><?php echo esc_html($stat['label']); ?></p>
            </div>
            <?php endforeach; ?>
        </div>
    </div>
</section>
<?php endif; ?>