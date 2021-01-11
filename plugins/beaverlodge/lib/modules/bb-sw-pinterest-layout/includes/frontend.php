<?php

if ($settings->filter_menu == 'yes') {?>
    <div class="masonry-navbar"></div>
<?php } ?>
    
<ul class="masonry">


        <?php

            $post = $settings->post_selection; 
            if( $settings->post_count == 'custom' ) {
                $count = $settings->post_qty;
            } else {
                $count = -1;
            }
            $args = array (
                'post_type'              => array( $post ),
                'posts_per_page'         => $count,
                'order'                  => 'DESC',
                'orderby'                => 'date',
            );

            $query = new WP_Query( $args );

            if ( $query->have_posts() ) {
                while ( $query->have_posts() ) {
                    $query->the_post();
                    if ($post != 'post') {
                        $term =get_taxonomies();
                    } else {
                        $term = 'category';
                    }
                    
                    $term_list = wp_get_post_terms(get_the_ID(), $term, array("fields" => "names"));
                                        
            ?>
    
                    <li class="item" data-tags=" <?php
                    
                                    foreach ($term_list as $terms) {
                                        echo $terms.',';
                                    }
                                    ?> ">
                        <?php
                        if ( has_post_thumbnail() ) {
                            the_post_thumbnail( 'medium' );
                        } ?>
                        <h<?php echo $settings->title_class; ?> class="sw-pin-title"><a href="<?php the_permalink(); ?>" rel="bookmark" title="Permanent Link to <?php the_title_attribute(); ?>"><?php the_title(); ?></a></h<?php echo $settings->title_class; ?>>
                        <?php the_excerpt(); ?>
                        <div class="readmore">
                            <a href="<?php the_permalink(); ?>" rel="bookmark" title="<?php the_title_attribute(); ?>" class="sw-pin-more"><?php echo $settings->read_more; ?></a>
                        </div>
                        
                    </li>
                    <?php
                }
                
            
            } else {
                // no posts found
            }

            wp_reset_postdata();

        ?>
    
</ul>