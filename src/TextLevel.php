<?php

//Affichage du niveau de lecture: Sur la page de chaque article, affichez clairement le niveau de lecture calculé et attribué à cet article.

namespace App;
require dirname(__DIR__, 1) . '/vendor/autoload.php';
use DaveChild\TextStatistics as TS;

class TextLevel
{
    public function __construct()
    {
        add_action( 'save_post', array( $this, 'levelReading' ), 10, 3 );
        add_action( 'post_updated', array( $this, 'levelReading' ), 10, 3 );
        add_filter( 'the_title', array($this, 'add_reading_level_to_title'), 10, 2 );

    }

    public function levelReading( $post_id, $post, $update ) {
        if ( ! $update ) { return; }
        if ( wp_is_post_revision( $post_id ) ) { return; }
        if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) { return; }
        if ( $post->post_type !== 'post' ) { return; }

        $textContent = strip_tags($post->post_content);

        
        if(is_string($textContent) == false) {
            return false;
        }
        
        $textStatistics = new TS\TextStatistics;
        $nbSyllables = $textStatistics->syllableCount($textContent);
        $nbWords = $textStatistics->wordCount($textContent);
        $nbSentence = $textStatistics->sentenceCount($textContent);
        
        $result = 206.835 - (1.015 * ($nbWords / $nbSentence)) - (84.6 * ($nbSyllables / $nbWords));

        update_post_meta( $post_id, 'reading_level', ceil($result) );        
    }
    
    
    public function add_reading_level_to_title( $title, $post_id ) {
        if ( get_post_type( $post_id ) === 'post' ) {
            $reading_level = get_post_meta( $post_id, 'reading_level', true );
            
            if ( ! empty( $reading_level ) ) {
                $title .= ' | Niveau : ' . $reading_level;
            }
        }
        
        return $title;
    }

}