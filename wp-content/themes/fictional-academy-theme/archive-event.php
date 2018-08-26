<?php get_header();
pageBanner([
    'title'=> 'All Events',
    'subtitle' => 'See what\'coming on'
]);
?>


<div class="container container--narrow page-section">
    <?php 
        while(have_posts()){
            the_post();
    get_template_part('template-parts/content-event');
        } 
    ?>
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