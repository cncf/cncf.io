<?php

use Psr\Log\AbstractLogger;

/**
 * PSR-3 logger class for Feed to Post.
 *
 * @since 3.7.7
 */
class WPRSS_FTP_Logger extends AbstractLogger {
    /**
     * @inheritdoc
     *
     * @since 3.7.7
     */
    public function log($level, $message, array $context = [])
    {
        $full_message = WPRSS_FTP_Utils::interpolate( $message, $context );

        WPRSS_FTP_Utils::log( $full_message, 'Feed to Post', $level );
    }
}
