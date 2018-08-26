<?php get_header();
pageBanner([
    'title'=> 'Past Events',
    'subtitle' => 'Recap of our past events'
]);

?>


<div class="container container--narrow page-section">
    
    <?php 
    $today = date('Ymd');
    $args = [
                'paged' => get_query_var('paged',1),
                'post_type'=>'event',
                'meta_key' => 'event_date',
                'orderby' => 'meta_value_num',
                'order' => 'ASC',
                'meta_query' => [
                    [
                        'key' => 'event_date',
                        'compare' => '<',
                        'value' => $today,
                        'type' => 'numeric'
                    ]
                ]
    ];
    $pastEvents = new WP_Query($args);
        while($pastEvents->have_posts()){
            $pastEvents->the_post();
    get_template_part('template-parts/content','event');
        } 
    ?>
    <?php 
        $args=[
            'total' => $pastEvents->max_num_pages
        ];
        echo paginate_links($args);
    ?>
    
    
</div>

<?php get_footer();?>