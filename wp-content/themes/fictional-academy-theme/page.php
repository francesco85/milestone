<?php get_header(); ?>
<?php
    while(have_posts()){
        the_post();
        pageBanner();
?>


  <div class="container container--narrow page-section">

   <?php
    
        
//        echo get_the_ID();
//        echo wp_get_post_parent_id(get_the_ID());
        $parent_id = wp_get_post_parent_id(get_the_ID());
        
        if($parent_id){
            echo "i'm child page";
    ?>
       
        <div class="metabox metabox--position-up metabox--with-home-link">
            <p><a class="metabox__blog-home-link" href="<?php echo get_permalink($parent_id); ?>"><i class="fa fa-home" aria-hidden="true"></i> Back to <?php echo get_the_title($parent_id); ?></a> <span class="metabox__main"><?php the_title(); ?></span></p>
        </div>
       
       
    <?php   
        }
        
    ?>
   
  <?php 
        $has_pages = get_pages([
            'child_of' => get_the_ID()
        ]);
        //se la pagina corrente ha una parent o se è una parent...
        if($parent_id || $has_pages):
    ?>
    <div class="page-links">
      <h2 class="page-links__title"><a href="<?php echo get_permalink($parent_id); ?>"><?php echo get_the_title($parent_id); ?></a></h2>
      <ul class="min-list">
        <!--<li class="current_page_item"><a href="#">Our History</a></li>
        <li><a href="#">Our Goals</a></li>-->
        <?php 
        
            if($parent_id){
                $children = $parent_id;
            }else{
                $children = get_the_ID();
            }
        //togliamo titolo, specifichiamo le pagine da mostrare nella sidebar, personalizziamo l'ordine che link del menu devono avere (gestiamo da 'Attributi della pagina'>'Ordinamento')
            wp_list_pages(array(
                'title_li' => null,
                'child_of' => $children,
                'sort_column' => 'menu_order'
            ));  
        ?>
        
      </ul>
    </div>

   <?php 
        endif;
    ?>
   
    <div class="generic-content">
      <?php the_content(); ?>
    </div>

  </div>
<?php } get_footer(); ?>