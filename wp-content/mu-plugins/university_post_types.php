<?php
   function university_post_types(){
    
       //Campus post type
       register_post_type('campus', [
        'capability_type' => 'campuses',
        'map_meta_cap' => true,
        'show_in_rest' =>true,
        'supports' => ['title','editor','excerpt'],
        'rewrite' => ['slug'=>'campuses'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Campuses',
            'add_new' => 'Aggiungi Campus',
            'edit_item' => 'Modifica Campus',
            'all_items'=> 'Tutti gli Campuses',
            'singular_name' => 'Campus'
        ],
        'menu_icon' => 'dashicons-location-alt'
    ]);
       
       //Event post type
       register_post_type('event', [
           //di defaulf capability_type è post ma settandolo come unico tipo wp è costretto a garantire esplicitamente i permessi di event ma per dire a wp di rendere obbligatori i permessi relativi agli eventi dobbiamo aggiungere map_meta_cap
        'capability_type' => 'event',
        'map_meta_cap' => true,
        'show_in_rest' =>true,
        'supports' => ['title','editor','excerpt'],
        'rewrite' => ['slug'=>'events'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Eventi',
            'add_new' => 'Aggiungi Evento',
            'edit_item' => 'Modifica Evento',
            'all_items'=> 'Tutti gli Eventi',
            'singular_name' => 'Evento'
        ],
        'menu_icon' => 'dashicons-calendar'
    ]);
       
       
    // Program post type
    register_post_type('program', [
     'show_in_rest' =>true,   
     'supports' => ['title'],
        'rewrite' => ['slug'=>'programs'],
        'has_archive' => true,
        'public' => true,
        'labels' => [
            'name' => 'Programmi',
            'add_new' => 'Aggiungi Programma',
            'edit_item' => 'Modifica Programma',
            'all_items'=> 'Tutti i Programmi',
            'singular_name' => 'Programma'
        ],
        'menu_icon' => 'dashicons-awards'
    ]);
       
    // Professors post type
    register_post_type('professor', [
        'show_in_rest' =>true,
        'supports' => ['title','editor','thumbnail'],
        
        
        'public' => true,
        'labels' => [
            'name' => 'Professori',
            'add_new' => 'Aggiungi Professore',
            'edit_item' => 'Modifica Professore',
            'all_items'=> 'Tutti i Professori',
            'singular_name' => 'Professore'
        ],
        'menu_icon' => 'dashicons-welcome-learn-more'
    ]);
       
    //note post type
    register_post_type('note', [
        'capability_type' => 'note',
        'map_meta_cap' => true,
        'show_in_rest' =>true,
        'supports' => ['title','editor'],
        'public' => false, //ma nasconde anche in admin dashboard
        'show_ui' => true, //per mostrare in admin dashboard
        'labels' => array(
            'name' => 'Note',
            'add_new' => 'Aggiungi Nota',
            'edit_item' => 'Modifica Nota',
            'all_items'=> 'Tutte le Note',
            'singular_name' => 'Nota'
        ),
        'menu_icon' => 'dashicons-welcome-write-blog'
    ]);
       
    //like post type
    register_post_type('like', [
        
//        'show_in_rest' =>false, o false o cancelliamo tanto default è false
        'supports' => ['title'],
        'public' => false, //ma nasconde anche in admin dashboard
        'show_ui' => true, //per mostrare in admin dashboard
        'labels' => array(
            'name' => 'Likes',
            'add_new' => 'Aggiungi Like',
            'edit_item' => 'Modifica Like',
            'all_items'=> 'Tutte le Likes',
            'singular_name' => 'Like'
        ),
        'menu_icon' => 'dashicons-heart'
    ]);
    
}

add_action('init','university_post_types');