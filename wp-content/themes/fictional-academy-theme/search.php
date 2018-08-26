<?php get_header();
pageBanner([
    'title'=> 'Search results',
    'subtitle' => 'You search for &ldquo;'. esc_html(get_search_query(false)) .'&rdquo;'
]);
?>


<div class="container container--narrow page-section">
    <?php 
    
    if(have_posts()):
    
        while(have_posts()){
            the_post();
            
            get_template_part('template-parts/content', get_post_type())
    ?>
    
      
    <?php
        }
    ?>
    <?php 
        $args=[
            'prev_text' => __('< Precedente'),
            'next_text' => __('Successivo >')
        ];
        echo paginate_links($args);
    else: echo '<h2 class="headline headline--small-plus">No results</h2>';
    
    endif;
    get_search_form();
    ?>
    
</div>

<?php get_footer();?>