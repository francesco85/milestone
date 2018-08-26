<?php get_header();
pageBanner([
    'title'=> 'All Programs',
    'subtitle' => 'See what\'coming on'
]);
?>


<div class="container container--narrow page-section">
    <ul class="link-list min-list">
        
       <?php 
        while(have_posts()){
            the_post();
    ?>
    <li><a href="<?php the_permalink();?>"><?php the_title();?></a></li>
      
    <?php
        } 
    ?>
    </ul>
    <?php 
        $args=[
            'prev_text' => __('< Precedente'),
            'next_text' => __('Successivo >')
        ];
        echo paginate_links($args);
    ?>
    <hr class="section-break">
   <p>Looking for past events? <a href="<?php echo site_url('/past-events'); ?>">Check out our past events</a></p> 
    
</div>

<?php get_footer();?>