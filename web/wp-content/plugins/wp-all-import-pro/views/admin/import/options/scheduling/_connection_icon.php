<?php
$scheduling = \Wpai\Scheduling\Scheduling::create();
?>
<span class="wpai-no-license" <?php if ($scheduling->checkLicense()) { ?> style="display: none;" <?php } ?> >

    <a href="#" style="z-index: 1000;" class="help_scheduling">
        <img style="width: 16px; top: 2px; position: absolute; left: 0;" class="scheduling-help" title="Automatic Scheduling is a paid service from Soflyy. Click for more info."
             src="<?php echo WP_ALL_IMPORT_ROOT_URL; ?>/static/img/s-question.png"/>
    </a>
</span>


<span class="wpai-license" <?php if (!$scheduling->checkLicense()) { ?> style="display: none;" <?php } ?> >
    <?php if ( $scheduling->checkConnection() ) {
        ?>
        <span title="Connection to WP All Export servers is stable and confirmed"
              style="background-image: none; width: 20px; height: 20px;;">
            <img class="scheduling-help" title="Connection to WP All Export servers is stable and confirmed" src="<?php echo WP_ALL_IMPORT_ROOT_URL; ?>/static/img/s-check.png" style="width: 16px;"/>
        </span>
        <?php
    } else  { ?>
        <img src="<?php echo WP_ALL_IMPORT_ROOT_URL; ?>/static/img/s-exclamation.png" style="width: 16px;"/>

        <?php
    }
    ?>
</span>