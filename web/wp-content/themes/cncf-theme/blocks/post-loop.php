<section class="basic-content container">
    <main class="blog-index">
        <div class="inner">
            <?php if (have_posts() ) : ?>

                <?php
                while ( have_posts() ) :
                    the_post();
                    $featured_img_url = get_the_post_thumbnail_url(get_the_ID(), 'blog-feature-pod');
                    ?>

            <article class="feature-post" style="background-image: url( <?php echo $featured_img_url; ?>)">
                <a href="<?php the_permalink(); ?>">
                                    <h4><?php the_title(); ?></h4></a>
                <p class="subtitle"><?php custom_excerpt_length(18); ?></p>
                <p><?php the_date('jS F'); ?> / <?php comments_number('No Comments', '1 Comment', '% comments'); ?></p>
            </article>

                <?php endwhile; ?>

                <?php numeric_posts_nav(); ?>

            <?php else : ?>
            <p>There are no posts here.</p>
            <?php endif; ?>
        </div>

    </main>
    <?php get_template_part('template-parts/popular-posts-aside'); ?>
</section>
