<section class="sitemap">
    <div class="container wrap">
        <h3>Pages</h3>
        <ul><?php wp_list_pages('title_li='); ?></ul>

        <!-- -------- -->

        <h3>Products by Subject</h3>

        <?php
        $args = array(
        'taxonomy'     => array( 'product_cat' ),
        'hierarchical' => true,
        'order'        => 'ASC',
        'orderby'      => 'name',
        'hide_empty'   => true,
        'numberposts'  => '-1',
        'parent'       => 0,
        'exclude'      => array( 96 ), // gift wrap
        );
        $cats = get_categories($args);
        echo '<ul>';
        foreach ( $cats as $cat ) :
            ?>

        <li><a href="<?php echo get_term_link($cat, $cat->taxonomy); ?>"
                 title="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></a></li>
            <?php
            // echo '<li><a href="'.get_permalink($cat_post).'">'.get_the_title($cat_post).'</a></li>';
        endforeach;
        echo '</ul>';
        wp_reset_postdata();
        ?>

        <!-- ----------- -->

        <h3>Products by Age</h3>

        <?php
        $args = array(
        'taxonomy'     => array( 'pa_age' ),
        'hierarchical' => true,
        'order'        => 'ASC',
        'orderby'      => 'name',
        'hide_empty'   => true,
        'numberposts'  => '-1',
        'parent'       => 0,
        );
        $cats = get_categories($args);
        echo '<ul>';
        foreach ( $cats as $cat ) :
            ?>

        <li><a href="<?php echo get_term_link($cat, $cat->taxonomy); ?>"
                 title="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></a></li>
            <?php
            // echo '<li><a href="'.get_permalink($cat_post).'">'.get_the_title($cat_post).'</a></li>';
        endforeach;
        echo '</ul>';
        wp_reset_postdata();
        ?>

        <!-- ----------- -->

        <h3>Products by Development Skill</h3>

        <?php
        $args = array(
        'taxonomy'     => array( 'development_skill' ),
        'hierarchical' => true,
        'order'        => 'ASC',
        'orderby'      => 'name',
        'hide_empty'   => true,
        'numberposts'  => '-1',
        'parent'       => 0,
        );
        $cats = get_categories($args);
        echo '<ul>';
        foreach ( $cats as $cat ) :
            ?>

        <li><a href="<?php echo get_term_link($cat, $cat->taxonomy); ?>"
                 title="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></a></li>
            <?php
            // echo '<li><a href="'.get_permalink($cat_post).'">'.get_the_title($cat_post).'</a></li>';
        endforeach;
        echo '</ul>';
        wp_reset_postdata();
        ?>

        <!-- -------------- -->

        <?php
        $args  = array(
        'post_type'    => array( 'services' ),
        'post_status'  => array( 'publish' ),
        'has_password' => false,
        );
        $query = new WP_Query($args);
        if ($query->have_posts() ) {
            ?>
        <h3>Services</h3>
        <ul>
            <?php
            while ( $query->have_posts() ) {
                $query->the_post();
                ?>
            <li>
                <a href="<?php the_permalink(); ?>"><?php the_title(); ?></a></li>
            <?php } ?>
        </ul>
            <?php
        }
        wp_reset_postdata();
        ?>




        <h3>Feeds</h3>
        <ul>
            <li><a title="Full content"
                     href="feed:<?php bloginfo('rss2_url'); ?>">Main RSS</a></li>
            <li><a title="Comment Feed"
                     href="feed:<?php bloginfo('comments_rss2_url'); ?>">Comment Feed</a></li>
        </ul>

        <h3>Blog Posts</h3>

        <p>By category: </p>
        <?php
        $cats = get_categories('exclude=');
        foreach ( $cats as $cat ) {
            $cat_slug  = array(
            'category_name' => $cat->slug,
            'exclude'       => '', // enter the ID or comma-separated list of page IDs to exclude
            'numberposts'   => '-1', // number of posts to show, default value is 5
            );
            $cat_array = get_posts($cat_slug);
            echo '<h3>' . $cat->cat_name . '</h3>';
            echo '<ul>';
            foreach ( $cat_array as $cat_post ) {
                echo '<li><a href="' . get_permalink($cat_post) . '">' . get_the_title($cat_post) . '</a></li>';
            }
            echo '</ul>';
        }
        ?>

        <h3>Monthly Archives</h3>
        <ul>
            <?php wp_get_archives('type=monthly&show_post_count=true'); ?>
        </ul>
    </div>
</section>
