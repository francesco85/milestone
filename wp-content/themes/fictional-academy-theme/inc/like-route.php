<?php

add_action('rest_api_init', 'universityLikeRoute');

function universityLikeRoute(){
    //uno per metodo post e uno per metodo delete (uno crea e l'altro cancella)
    register_rest_route('university/v1','likeManage', array(
        'methods' => 'POST',
        'callback' => 'createLike'
    ));
    
    register_rest_route('university/v1','likeManage', array(
        'methods' => 'DELETE',
        'callback' => 'deleteLike'
    ));
}



function createLike($data){
    //altro modo sarebbe con current_user_can('publich_note')
    //if sarà sempre falso se non mettiamo nonce code nel Like.js nella chiamata ajax nella funzione createLike
    if(is_user_logged_in()){
        $id = sanitize_text_field($data['professorId']);
        $existsQuery = new WP_Query(array(
                            'author' => get_current_user_id(),
                            'post_type' => 'like',
                            'meta_query' => array(
                                array(
                                    'key' => 'liked_professor_id',
                                    'compare' => '=',
                                    'value' => $id
                                )
                            )
                        ));
        if($existsQuery->found_posts == 0 AND get_post_type($id) == 'professor'){
            
            //creiamo nuovo post direttamente da qui!
            //funzione wp_insert_post restituisce id
            return wp_insert_post(array(
                'post_type' => 'like',
                'post_status' => 'publish',
                'post_title' => 'Our like post n2',
                'meta_input' => array(
                    'liked_professor_id' => $id
                )
            ));
        }else{
            die('Invalid id');
        }
    }else{
        die('Only logged in user can create a like');
    }
    
}

function deleteLike($data){
    $likeId = sanitize_text_field($data['like']);
    //solo chi ha creato il like può cancellarlo e quindi se user corrente è quello che ha creato il like allora cancella
    if(get_current_user_id() == get_post_field('post_author',$likeId) AND get_post_type($likeId) == 'like'){
        //2 parametri: id e se vogliamo o no skippare la trash, quindi se vogliamo cancella definitivamente o cestinare 
        wp_delete_post($likeId, true);
        return 'Like deleted';
    }else{
        die('No permission to delete');
    }
}