<?php
/* ====================== */
/* BOOK DISPLAY FUNCTIONS */
/* ====================== */

//Prints the subtitle, if it exists.
function book_subtitle( $bfr = '<h2>', $aft = '</h2>' ) { 
    if ( has_subtitle( get_the_ID() ) ) {
        echo $bfr . get_subtitle(). $aft;
    };
};
    

//Prints comma-separated list of contributors, if any.
function the_contr_names( $bfr = '<h3>', $aft = '</h3>' ) {
    global $post;
    $get_authors = get_post_meta ($post->ID, 'contributors', false);
                
    if ( ! empty ( $get_authors[0] ) ) {
        echo $bfr;
        foreach ( $get_authors as $author ) {
            if ( $author == end ( $get_authors ) ) {
                echo '<a href="' . get_the_permalink ( $author ) . '">' . get_the_title ( $author ) . '</a>'; //No comma after last contributor
            } else {
                echo '<a href="' . get_the_permalink ( $author ) . '">' . get_the_title ( $author ) . '</a>, ';
            };
        };
        echo $aft;
    };
};


//Prints the name of the series and the volume number, if any.
function the_series( $bfr = '<h4>', $aft = '</h4>' ) {
    global $post;
    $series = get_post_meta ($post->ID, 'series', false);
    
    if ( ! empty ( $series[0] ) ) {
        echo $bfr . '<a href="' . get_the_permalink ( $series[0] ) . '">' . get_the_title ( $series[0] ) . ' series</a>';
        if ( '' != get_scpt_formatted_meta ( 'number-in-series' ) ) {
            echo ' (Book ' . get_scpt_formatted_meta ( 'number-in-series' ) . ')';
        };
        echo $aft;
    };  
};


//Prints the ISBN, if it is set. Includes a span tag to make "ISBN" small caps (only functional if properly styled in CSS).
function the_isbn( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_scpt_formatted_meta ( 'isbn-13' ) ) {
        echo $bfr . '<span class="sc">ISBN ' . get_scpt_formatted_meta ( 'isbn-13' ) . $aft;
    };
};

//Prints the availability, if it is set.
function the_availability( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_scpt_formatted_meta ( 'availability' ) ) {
        echo $bfr . get_scpt_formatted_meta ( 'availability' ) . $aft;
    };
};


//Prints the pub date in the format: Month DD, YYYY.
function the_pub_date( $bfr = '<li>', $aft = '</li>' ) {
    $pubdate = get_scpt_formatted_meta ( 'publication-date' );
    if ( ( ! empty ( $pubdate ) ) && ( $pubdate != '19700101' ) ) {
        echo $bfr . date ( "F d, Y", strtotime( get_scpt_formatted_meta ( 'publication-date' ) ) ) . $aft;
    };
};


//Prints the price and currency code, if they are set. Includes a span tag to make currency code small caps (only functional if properly styled in CSS).
function the_price( $bfr = '<li>', $aft = '</li>' ) {
    $currency = get_scpt_formatted_meta ( 'currency' );
    $price = get_scpt_formatted_meta ( 'price' );
    
    if ( ! empty( $price ) ) {
        echo $bfr;
        if ( empty( $currency ) ) {
            echo '$' . $price; //Prints price with dollar sign as default when no currency is set
        } else {
            if ( $currency == '$ CAD' ) { //Defines display for each currency option
                echo '$' . $price . ' <span class="sc">CAD</span>';
            } elseif ( $currency == '$ USD' ) {
                echo '$' . $price . ' <span class="sc">USD</span>';
            } elseif ( $currency == '£ GBP' ) {
                echo '£' . $price . ' <span class="sc">GBP</span>';
            };
        };
        echo $aft;
    };
};


//Prints the print format.
function the_format( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_scpt_formatted_meta ( 'format' ) ) {
        echo $bfr . get_scpt_formatted_meta ( 'format' ) . $aft;
    };
};


//Prints the print width, height and page count, if they are set. Display changes depending on which values are set.
function the_print_dimensions( $bfr = '<li>', $aft = '</li>' ) {
    $bookwidth = get_scpt_formatted_meta ( 'width' );
    $bookheight = get_scpt_formatted_meta ( 'height' );
    $bookpages = get_scpt_formatted_meta ( 'page-count' );
    
    if ( '' != $bookwidth ) {
        echo $bfr . $bookwidth;
        if ( '' != $bookheight ) {
            echo ' × ' . $bookheight;
        };
        echo '"';
        if ( '' != $bookpages ) {
            echo ' × ' . $bookpages . ' pp';
        };
        echo $aft;
    } else {
        if ( '' != $bookheight ) {
            echo $bfr . $bookheight . '"';
            if ( '' != $bookpages ) {
                echo ' × ' . $bookpages . ' pp';
            }
            echo $aft;
        } else {
            if ( '' != $bookpages ) {
                echo $bfr . $bookpages . ' pp' . $aft;
            };
        };
    };
};


//Prints a comma-separated list of the genres, if any.
function the_genres( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_the_terms( get_the_ID(), 'genre' ) ) {
        echo $bfr . 'Genre: ';
        the_terms( get_the_ID(), 'genre', '', ', ', '' );
        echo '.' . $aft;
    };
};


//Prints the book reviews, if any.
function the_book_reviews( $bfr = '<hr />', $aft = '' ) {
    if ( '' != get_scpt_formatted_meta ( 'review-field' ) ) {
        echo $bfr . '<h4 class="toggle-title">Reviews of ' . get_the_title() . '</h4><div class="toggle-wrap related-posts">';
        echo get_scpt_formatted_meta ( 'review-field' ) . '</div>' . $aft;
    };
};


//Prints author photos and short bios, with links to their pages.
function the_contr_bios( $bfr = '<hr />', $aft = '' ) {
    global $post;
    $get_authors = get_post_meta ($post->ID, 'contributors', false);
    
    if ( $get_authors[0] != '' ) {
        echo $bfr . '<div class="related-posts">';
        foreach ($get_authors as $author) {
            echo '<div class="row">';
            echo '<div class="thumb-holder small-3 columns text-right"><a href="' . get_the_permalink($author) . '">' . get_the_post_thumbnail($author) . '</a></div>';
            echo '<div class="small-9 columns"><h2><a href="' . get_the_permalink($author) . '">' . get_the_title($author) . '</a></h2>';
            echo '<p>' . get_short_desc($author) . '</p></div></div>';
        };
        echo '</div>' . $aft;
    };
        
};

//Prints short summary of all books in the same series. Does not display if there is only one book in the series.
function books_in_same_series( $bfr = '<hr />', $aft = '' ) {
    global $post;
    $series_ID = get_post_meta ($post->ID, 'series', false);

    $books_in_same_series = get_posts( array(
        'post_type'      => 'book',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_query'     => array(
            array(
                'key'     => 'series',
                'value'   => $series_ID[0],
                'compare' => 'LIKE'
                )
           )
        ) );
    
    if( count ( $books_in_same_series ) > 1 ) {
        echo $bfr . '<h4 class="toggle-title">More ' . get_the_title($series_ID[0]) . ' series titles</h4><div class="toggle-wrap related-posts">';
        foreach ( $books_in_same_series as $book ) {
            if ( $book->ID != get_the_ID() ) {
                setup_postdata( $book );
                echo '<div class="row">';
                if ( has_post_thumbnail($book->ID) ) {
                    echo '<div class="thumb-holder small-3 columns text-right"><a href="' . get_the_permalink($book) . '">' . get_the_post_thumbnail($book->ID) . '</a></div>';
                };
                echo '<div class="small-9 columns"><h2><a href="' . get_the_permalink($book) . '">' . get_the_title($book) . '</a></h2>';
                echo '<p>' . get_short_desc($book) . '</p></div></div>';
            };
        };
        echo '</div>' . $aft;
    };
};



/* ============================= */
/* CONTRIBUTOR DISPLAY FUNCTIONS */
/* ============================= */


//Prints the contributor's roles, if any.
function the_roles( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_the_terms( get_the_ID(), 'role' ) ) {
        echo $bfr;
        the_terms( get_the_ID(), 'role', '', ', ', '' );
        echo $aft;
    };
};


//Prints a link to the contributor's website, if it exists.
function the_contr_website( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_scpt_formatted_meta ( 'website' ) ) {
        echo $bfr . '<a href="' . get_scpt_formatted_meta ( 'website' ) . '" target="_blank">Website</a>' . $aft;
    };
};
   

//Prints the contributor's Facebook page, if it exists.
function the_contr_fb( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_scpt_formatted_meta ( 'facebook' ) ) {
        echo $bfr . '<a href="' . get_scpt_formatted_meta ( 'facebook' ) . '" target="_blank">Facebook</a>' . $aft;
    };
};


//Prints the contributor's Twitter handle, if it exists.
function the_contr_twitter( $bfr = '<li>', $aft = '</li>' ) {
    if ( '' != get_scpt_formatted_meta ( 'twitter' ) ) {
        echo $bfr . '<a href="https://twitter.com/' . get_scpt_formatted_meta ( 'twitter' ) . '" target="_blank">Twitter</a>' . $aft;
    };
};


//Prints short summary of all books by a contributor.
function books_by_author( $bfr = '<hr />', $aft = '' ) {
    global $post;

    $books_by_author = get_posts( array(
        'post_type'      => 'book',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_query'     => array(
            array(
                'key'     => 'contributors',
                'value'   => get_the_ID(),
                'compare' => 'LIKE'
                )
           )
        ) );
    
    if( $books_by_author ) {
        echo $bfr . '<h4 class="toggle-title">Books by ' . get_the_title() . '</h4><div class="toggle-wrap related-posts">';
        foreach ( $books_by_author as $book ) {
            setup_postdata( $book );
            echo '<div class="row">';
            if ( has_post_thumbnail($book->ID) ) {
                echo '<div class="thumb-holder small-3 columns text-right"><a href="' . get_the_permalink($book) . '">' . get_the_post_thumbnail($book->ID) . '</a></div>';
            };
            echo '<div class="small-9 columns"><h2><a href="' . get_the_permalink($book) . '">' . get_the_title($book) . '</a></h2>';
            echo '<p>' . get_short_desc($book) . '</p></div></div>';
        };
        echo '</div>' . $aft;
    };
};




/* ============================= */
/* CONTRIBUTOR DISPLAY FUNCTIONS */
/* ============================= */


//Use the_contr_names(); and the_genres(); as above.

//Prints short summary of all books in a series.
function books_in_series( $bfr = '<hr />', $aft = '' ) {
    global $post;

    $books_in_series = get_posts( array(
        'post_type'      => 'book',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_query'     => array(
            array(
                'key'     => 'series',
                'value'   => get_the_ID(),
                'compare' => 'LIKE'
                )
           )
        ) );
    
    if( $books_in_series ) {
        echo $bfr . '<h4 class="toggle-title">Books in the ' . get_the_title() . ' series</h4><div class="toggle-wrap related-posts">';
        foreach ( $books_in_series as $book ) {
            setup_postdata( $book );
            echo '<div class="row">';
            if ( has_post_thumbnail($book->ID) ) {
                echo '<div class="thumb-holder small-3 columns text-right"><a href="' . get_the_permalink($book) . '">' . get_the_post_thumbnail($book->ID) . '</a></div>';
            };
            echo '<div class="small-9 columns"><h2><a href="' . get_the_permalink($book) . '">' . get_the_title($book) . '</a></h2>';
            echo '<p>' . get_short_desc($book) . '</p></div></div>';
        };
        echo '</div>' . $aft;
    };
};


//Prints a comma-separated list of the titles of all books in a series.
function books_in_series_list( $bfr = '<p>', $aft = '</p>' ) {
    global $post;

    $books_in_series_list = get_posts( array(
        'post_type'      => 'book',
        'posts_per_page' => -1,
        'orderby'        => 'meta_value',
        'meta_query'     => array(
            array(
                'key'     => 'series',
                'value'   => get_the_ID(),
                'compare' => 'LIKE'
                )
           )
        ) );
    
    if( $books_in_series_list ) {
        echo $bfr;
        foreach ( $books_in_series_list as $book ) {
            setup_postdata( $book );
            if ( $book == end ( $books_in_series_list ) ) {
                echo '<a href="' . get_the_permalink ( $book ) . '">' . get_the_title ( $book ) . '</a>'; //No comma after last contributor
            } else {
                echo '<a href="' . get_the_permalink ( $book ) . '">' . get_the_title ( $book ) . '</a>, ';
            };
        };
        echo $aft;
    };
};