<?php

 add_action('rest_api_init','uniRegisterSearch');
function uniRegisterSearch(){
    //namespace,route,array(descrive che succede quando si accede a questa url)
    register_rest_route('university/v1','search',array(
        //Questa costante che sostituisce GET e più sicura di GET perche ci possono essere server che usano metodo diverso..così siamo sicuri che avremo accesso
        'methods' => WP_REST_SERVER::READABLE,
        //funzione callback che restituirà dati json
        'callback' => 'univSearchRes'
    ));
}


function univSearchRes($data){
    $mainQuery = new WP_Query(array(
        'post_type' => array('post','page','professor','program','campus','event'),
        //contro mal injections
        's' => sanitize_text_field($data['term'])
    ));     
    $results = [
        'generalInfo' => array(),
        'professors' => array(),
        'programs' => array(),
        'events' => array(),
        'campuses' => array()
    ];
    while($mainQuery->have_posts()){
        $mainQuery->the_post();
        if(get_post_type() == 'post' OR get_post_type() == 'page'){
            //due parametri: array a cui vuoi aggiungere elemento, ciò che vuoi aggiungere all'array
            array_push($results['generalInfo'], array(
                'author' => get_the_author(),
                'postType'=> get_post_type(),
                'title' => get_the_title(),
                'permalink'=> get_the_permalink()
            ));
        }
        
        if(get_post_type() == 'professor'){
            //due parametri: array che vuoi aggiungere, ciò che vuoi aggiungere all'elemento
            array_push($results['professors'], array(
                'author' => get_the_author(),
                'postType'=> get_post_type(),
                'title' => get_the_title(),
                'permalink'=> get_the_permalink(),
                //2 parametri: post(0 = post corrente) e size
                'photo' => get_the_post_thumbnail_url(0,'professorLandscape')
            ));
        }
        
        if(get_post_type() == 'program'){
            
            $relatedCampuses = get_field('related_campuses');
            if(!empty($relatedCampuses)){
                foreach($relatedCampuses as $campus){
                    array_push($results['campuses'],array(
                        'title' => get_the_title($campus),
                        'permalink' => get_the_permalink($campus)
                    ));
                }
            }
            
            //due parametri: array che vuoi aggiungere, ciò che vuoi aggiungere all'elemento
            array_push($results['programs'], array(
                'author' => get_the_author(),
                'postType'=> get_post_type(),
                'title' => get_the_title(),
                'permalink'=> get_the_permalink(),
                'id' => get_the_id()
            ));
        }
        
        if(get_post_type() == 'campus'){
            //due parametri: array che vuoi aggiungere, ciò che vuoi aggiungere all'elemento
            array_push($results['campuses'], array(
                'author' => get_the_author(),
                'postType'=> get_post_type(),
                'title' => get_the_title(),
                'permalink'=> get_the_permalink()
            ));
        }
        
        if(get_post_type() == 'event'){
            
            $eventDate = new DateTime(get_field('event_date'));
            $excerpt = null;
                if(has_excerpt()){
                    $excerpt= get_the_excerpt();
                }else{
                    $excerpt= wp_trim_words(get_the_content(),18);
                }
            //due parametri: array che vuoi aggiungere, ciò che vuoi aggiungere all'elemento
            array_push($results['events'], array(
                'author' => get_the_author(),
                'postType'=> get_post_type(),
                'title' => get_the_title(),
                'permalink'=> get_the_permalink(),
                'month' =>$eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $excerpt
                
            ));
        }
        
    }
    $mainQuery->wp_reset_postdata();
    
    if($results['programs']){
        $programMetaQuery = array('relation'=>'OR');
    
    foreach($results['programs'] as $item){
        array_push($programMetaQuery, array(
            'key'=>'related_programs',
            'compare'=> 'LIKE',
            'value'=> '"'. $item['id'] .'"'
        ));   
    }
    
    $programRelationQuery = new WP_Query(array(
        'post_type' => array('professor','event','campus'),
        //molteplici filtri = molteplici array all'interno di meta_query
        'meta_query' => $programMetaQuery 
    ));
    
    while($programRelationQuery->have_posts()){
        $programRelationQuery->the_post();
        
        
        if(get_post_type() == 'professor'){
            //due parametri: array che vuoi aggiungere, ciò che vuoi aggiungere all'elemento
            array_push($results['professors'], array(
                'author' => get_the_author(),
                'postType'=> get_post_type(),
                'title' => get_the_title(),
                'permalink'=> get_the_permalink(),
                //2 parametri: post(0 = post corrente) e size
                'photo' => get_the_post_thumbnail_url(0,'professorLandscape')
            ));
        }
        
        if(get_post_type() == 'event'){
            
            $eventDate = new DateTime(get_field('event_date'));
            $excerpt = null;
                if(has_excerpt()){
                    $excerpt= get_the_excerpt();
                }else{
                    $excerpt= wp_trim_words(get_the_content(),18);
                }
            //due parametri: array che vuoi aggiungere, ciò che vuoi aggiungere all'elemento
            array_push($results['events'], array(
                'author' => get_the_author(),
                'postType'=> get_post_type(),
                'title' => get_the_title(),
                'permalink'=> get_the_permalink(),
                'month' =>$eventDate->format('M'),
                'day' => $eventDate->format('d'),
                'description' => $excerpt
                
            ));
        }
        
    }
    //usiamo array_unique per far si che non si ripetano gli stessi risultati(cercando biology potremmo trovare due  risultati, uno per keyword e uno per relazione)
    //poi wrappiamo tutto in array_values per rinumerare array rispettando l'ordine di ciclo
    $results['professors'] = array_values(array_unique($results['professors'], SORT_REGULAR));     
    $results['events'] = array_values(array_unique($results['events'], SORT_REGULAR));     
    $results['campuses'] = array_values(array_unique($results['campuses'], SORT_REGULAR));     
    }
    
    
     
    return $results;
    
}