<?php
namespace ShortPixel;

$total_circle = 289.027;
$total =round($view->averageCompression);

if( $total  >0 ) {
		$total_circle = round($total_circle-($total_circle * $total /100));
}

?>

<div class="sp-bulk-summary">
        <span><?php esc_html_e('Average optimization', 'shortpixel-image-optimiser'); ?></span><br>
        <a title="<?php esc_html_e('Average optimization', 'shortpixel-image-optimiser'); ?>">
        <svg class="opt-circle-average" viewBox="-10 0 120 100">
                                    <path class="trail" d="
                                            M 50,50
                                            m 0,-46
                                            a 46,46 0 1 1 0,92
                                            a 46,46 0 1 1 0,-92
                                            " stroke-width="16" fill-opacity="0">
                                    </path>
                                    <path class="path" d="
                                            M 50,50
                                            m 0,-46
                                            a 46,46 0 1 1 0,92
                                            a 46,46 0 1 1 0,-92
                                            " stroke-width="16" fill-opacity="0" style="stroke-dasharray: 289.027px, 289.027px; stroke-dashoffset: <?php echo esc_html($total_circle) ?>">
                                    </path>
                                    <text class="text" x="52" y="55"><?php echo esc_html($total) ?>%</text>
                            </svg>
            </a>

</div>
