<?php
function renderButton($buttonText, $isWizard, $continue = false, $saveOnly = false)
{
    ?>
    <div class="wpai-save-scheduling-button-blue button button-primary button-hero wpallimport-large-button <?php if($saveOnly) {?> save_only <?php } ?> <?php if($continue || $saveOnly) { ?> wpallimport-button-small-blue <?php } ?>"
         style="position: relative; <?php if ($saveOnly) { ?> width: 135px; background-image: none; <?php } else if ($continue) { ?> width: 135px; <?php } else { ?>width: 285px; <?php } ?> margin-left: 5px;"
    >
        <svg width="30" height="30" viewBox="0 0 1792 1792"
             xmlns="http://www.w3.org/2000/svg"
             style="fill: white; position:absolute; top: 8px; <?php if($continue || $saveOnly) { ?> left: 5px; <?php } else {?> left: 17px; <?php } ?>  display: none;">
            <path
                    d="M1671 566q0 40-28 68l-724 724-136 136q-28 28-68 28t-68-28l-136-136-362-362q-28-28-28-68t28-68l136-136q28-28 68-28t68 28l294 295 656-657q28-28 68-28t68 28l136 136q28 28 28 68z"
                    fill="white"/>
        </svg>
        <div class="easing-spinner" style="top: 8px; left: 17px; display: none;">
            <div class="double-bounce1"></div>
            <div class="double-bounce2"></div>
        </div>
        <div class="save-text"
            <?php
            $left = 60;
            if ($isWizard) {
                $left = 70;
            }

            if($isWizard && $continue) {
                $left = 35;
            }

            if ($saveOnly) {
                $left = 40;
            }
            ?>
             style="display: block; position:absolute; <?php echo "left: $left"."px;" ?> top:0; user-select: none;">
            <?php _e($buttonText, PMXI_Plugin::LANGUAGE_DOMAIN); ?>
        </div>
    </div>
    <?php
}

?>