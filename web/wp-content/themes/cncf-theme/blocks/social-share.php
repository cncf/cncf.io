<?php

$url = urlencode(get_permalink());

$title = htmlspecialchars(urlencode(html_entity_decode(get_the_title(), ENT_COMPAT, 'UTF-8')), ENT_COMPAT, 'UTF-8');

// $image = wp_get_attachment_image( get_post_thumbnail_id( $post->ID ), 'full' );
// if ($image) {
// $image = urlencode($image);
// }

$facebookURL  = 'https://www.facebook.com/sharer/sharer.php?u=' . $url . '&t=' . $title;
$twitterURL   = 'https://twitter.com/intent/tweet?text=' . $title . '&amp;url=' . $url . '&amp;via=' . $twitter . '&hashtags=makeyourmark,futurejob';
$tumblrURL    = 'https://www.tumblr.com/widgets/share/tool?&url=' . $url;
$WhatsApp     = 'https://api.whatsapp.com/send?text=' . $title . ' ' . $url;
$messengerURL = 'fb-messenger://share/?link=' . $url . '&app_id=2012739652071846';
$redditURL    = 'https://www.reddit.com/submit?url=' . $url . '&title=' . $title;
$linkedinURL  = 'https://www.linkedin.com/shareArticle?mini=true&url=' . $url . '&summary=' . $title . '';
$mailto       = 'mailto:?subject=' . $title . '&body=' . $url . '';
?>

<div class="share-icons">
  <!-- facebook -->
  <a target="_blank" aria-label="Share on Facebook"
     title="Share on Facebook"
     href="<?php echo $facebookURL; ?>"><?php the_svg('images/social/facebook.svg'); ?></a>

  <!-- twitter -->
  <a target="_blank" aria-label="Share on Twitter"
     title="Share on Twitter"
     href="<?php echo $twitterURL; ?>"><?php the_svg('images/social/twitter.svg'); ?></a>

  <!-- tumblr  -->
  <a target="_blank" aria-label="Share on Tumblr"
     title="Share on Tumblr"
     href="<?php echo $tumblrURL; ?>">
    <?php // the_svg('images/social/tumblr.svg'); ?>
  </a>

  <!-- messenger -->
  <a target="_blank" aria-label="Share on Messenger"
     title="Share on Messenger"
     class="hideover768"
     href="<?php echo $messengerURL; ?>">
    <?php // the_svg('images/social/messenger.svg'); ?>
  </a>

  <!-- whatsApp -->
  <a target="_blank" aria-label="Share on WhatsApp"
     title="Share on WhatsApp"
     href="<?php echo $WhatsApp; ?>"><?php the_svg('images/social/whatsapp.svg'); ?></a>

  <!-- reddit -->
  <a target="_blank" aria-label="Share on Reddit"
     title="Share on Reddit"
     href="<?php echo $redditURL; ?>"><?php // the_svg('images/social/reddit.svg'); ?></a>

  <!-- linkedin -->
  <a target="_blank" aria-label="Share on Linkedin"
     title="Share on Linkedin"
     href="<?php echo $linkedinURL; ?>"><?php the_svg('images/social/linkedin.svg'); ?></a>

  <!-- sendto email -->
  <a target="_blank" aria-label="Share by Email"
     title="Share by Email"
     href="<?php echo $mailto; ?>"><?php // the_svg('images/social/email.svg'); ?></a>

</div>
