<?php
// Get options from FinanceGlow settings
$social_links = get_option('financeglow_social_links', []);
?>

<div class="links-section">
    <div class="container">
        <div class="row align-items-center">
            <!-- Left Section: Date and Time -->
            <div class="col-md-9">
                <div class="date-time">
                    <span class="icon-calendar">📅</span> 
                    <span id="local-date"><?php echo esc_html(date('F j, Y')); ?></span>
                    <span class="icon-clock ml-3">⏰</span> 
                    <span id="local-time"><?php echo esc_html(date('H:i:s')); ?></span>
                </div>
            </div>
            <!-- Right Section: Social Media Icons -->
            <div class="col-md-3 text-right">
                <?php foreach ($social_links as $platform => $url): ?>
                    <?php if ($url): ?>
                        <a href="<?php echo esc_url($url); ?>" target="_blank" class="social-icon <?php echo esc_attr($platform); ?>">
                            <?php echo wp_kses_post(get_social_icon($platform)); ?>
                        </a>
                    <?php endif; ?>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>

<?php
function get_social_icon($platform) {
    $icons = [
        'facebook' => '<i class="fab fa-facebook-f"></i>',
        'twitter' => '<i class="fab fa-twitter"></i>',
        'instagram' => '<i class="fab fa-instagram"></i>',
        'linkedin' => '<i class="fab fa-linkedin-in"></i>',
        'youtube' => '<i class="fab fa-youtube"></i>',
    ];
    return $icons[$platform] ?? '';
}
?>

<script>
    function updateTime() {
        var now = new Date();
        document.getElementById('local-date').textContent = now.toLocaleDateString();
        document.getElementById('local-time').textContent = now.toLocaleTimeString();
    }
    setInterval(updateTime, 1000); // Update every second
    document.addEventListener('DOMContentLoaded', updateTime); // Initial call
</script>
