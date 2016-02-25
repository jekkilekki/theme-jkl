<?php
/**
 * Custom template tags for this theme.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package jkl
 */

if ( ! function_exists( 'jkl_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function jkl_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'jkl' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

	$byline = sprintf(
		esc_html_x( '%s', 'post author', 'jkl' ),
		'<span class="author vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( 'ID' ) ) ) . '">' . esc_html( get_the_author() ) . '</a></span>'
	);
        
        // Display the author avatar if the author has a Gravatar
        $author_id = get_the_author_meta( 'ID' );
        // if( jkl_validate_gravatar( $author_id ) ) {
            echo '<div class="meta-content has-avatar">';
            echo '<div class="author-avatar">' . get_avatar( $author_id ) . '</div>';
        // } else {
            echo '<div class="meta-content-text">';

	echo '<span class="byline">by ' . $byline . '</span><span class="posted-on">on ' . $posted_on . '</span>'; // WPCS: XSS OK.

        // Add Category list below
        if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'jkl' ) );
		if ( $categories_list && jkl_categorized_blog() ) {
			printf( '<br><span class="cat-links">' . esc_html__( '%1$s', 'jkl' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}
        }
        
        // Add Comments Link
        if ( ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
                echo '<span class="comments-link">';
                comments_popup_link( esc_html__( 'Leave a comment', 'jkl' ), esc_html__( '1 Comment', 'jkl' ), esc_html__( '% Comments', 'jkl' ) );
                echo '</span>';
        } 
        
        echo '</div><!-- .meta-content -->';
        echo '</div><!-- .meta-content-text -->';
}
endif;

if ( ! function_exists( 'jkl_entry_footer' ) ) :
/**
 * Prints HTML with meta information for the categories, tags and comments.
 */
function jkl_entry_footer() {
	// Hide category and tag text for pages.
	if ( 'post' === get_post_type() ) {
		/* translators: used between list items, there is a space after the comma */
		$categories_list = get_the_category_list( esc_html__( ', ', 'jkl' ) );
		if ( $categories_list && jkl_categorized_blog() ) {
			printf( '<span class="cat-links">' . esc_html__( 'Posted in %1$s', 'jkl' ) . '</span>', $categories_list ); // WPCS: XSS OK.
		}

		/* translators: used between list items, there is a space after the comma */
		$tags_list = get_the_tag_list( '', esc_html__( ', ', 'jkl' ) );
		if ( $tags_list ) {
			printf( '<span class="tags-links">' . esc_html__( 'Tagged %1$s', 'jkl' ) . '</span>', $tags_list ); // WPCS: XSS OK.
		}
	}

	if ( ! is_single() && ! post_password_required() && ( comments_open() || get_comments_number() ) ) {
		echo '<span class="comments-link">';
		comments_popup_link( esc_html__( 'Leave a comment', 'jkl' ), esc_html__( '1 Comment', 'jkl' ), esc_html__( '% Comments', 'jkl' ) );
		echo '</span>';
	}

	edit_post_link(
		sprintf(
			/* translators: %s: Name of current post */
			esc_html__( 'Edit %s', 'jkl' ),
			the_title( '<span class="screen-reader-text">"', '"</span>', false )
		),
		'<span class="edit-link">',
		'</span>'
	);
}
endif;

/**
 * Returns true if a blog has more than 1 category.
 *
 * @return bool
 */
function jkl_categorized_blog() {
	if ( false === ( $all_the_cool_cats = get_transient( 'jkl_categories' ) ) ) {
		// Create an array of all the categories that are attached to posts.
		$all_the_cool_cats = get_categories( array(
			'fields'     => 'ids',
			'hide_empty' => 1,
			// We only need to know if there is more than one category.
			'number'     => 2,
		) );

		// Count the number of categories that are attached to the posts.
		$all_the_cool_cats = count( $all_the_cool_cats );

		set_transient( 'jkl_categories', $all_the_cool_cats );
	}

	if ( $all_the_cool_cats > 1 ) {
		// This blog has more than 1 category so jkl_categorized_blog should return true.
		return true;
	} else {
		// This blog has only 1 category so jkl_categorized_blog should return false.
		return false;
	}
}

/**
 * Flush out the transients used in jkl_categorized_blog.
 */
function jkl_category_transient_flusher() {
	if ( defined( 'DOING_AUTOSAVE' ) && DOING_AUTOSAVE ) {
		return;
	}
	// Like, beat it. Dig?
	delete_transient( 'jkl_categories' );
}
add_action( 'edit_category', 'jkl_category_transient_flusher' );
add_action( 'save_post',     'jkl_category_transient_flusher' );


/* 
 * #############################################################################
 * 
 * Custom Template Tags
 * 
 * ############################################################################# 
 */

/**
 * DYNAMIC Copyright for the footer
 */
 function jkl_dynamic_copyright() {

    global $wpdb;

    $copyright_dates = $wpdb->get_results( "SELECT YEAR(min(post_date_gmt)) AS firstdate, YEAR(max(post_date_gmt)) AS lastdate FROM $wpdb->posts WHERE post_status = 'publish' " );
    $output = '';
    $blog_name = get_bloginfo();

    if ( $copyright_dates ) {
        $copyright = "&copy; " . $copyright_dates[0]->firstdate;
        if ( $copyright_dates[0]->firstdate != $copyright_dates[0]->lastdate ) {
            $copyright .= " &ndash; " . $copyright_dates[0]->lastdate;
        }
        $output = $copyright . " " . $blog_name;
    }
    return $output;
}

/**
 * Attempting to split the main nav menu with the logo
 * @link: Courtesy: http://pateason.com/horizontal-split-nav/
 */
function jkl_split_main_nav( $menu_name = null, $raw = false ) {
    
    if ( $menu_name == null || !is_string( $menu_name ) ) {
        return false;
    }
    $output = new stdClass();
    
    // Check if the menu exists and is set
    if ( ( $locations = get_nav_menu_locations() ) && isset( $locations[ $menu_name ] ) ) {
        
        $menu = wp_get_nav_menu_object( $locations[ $menu_name ] );
        $menu_items = wp_get_nav_menu_items( $menu->term_id );
        
        // Create new array with only top level objects
        $newMenu = array();
        foreach( $menu_items as $item ) {
            if( $item->menu_item_parent != 0 ) continue;
            
            // get subnav
            $parentID = $item->ID;
            $item->subnav = array_filter( $menu_items, function( $v ) use ( $parentID ) {
                if ( $v->menu_item_parent == $parentID ) return $v; 
            });
            
            array_push( $newMenu, $item );
        }
        
        // Split menu array in half
        $len = count( $newMenu );
        $firstThis = array_slice( $newMenu, 0, $len / 2 );
        $thenThat = array_slice( $newMenu, $len / 2 );
        
        
        if( $raw==true ) {
            $output->left_menu = $firstThis;
            $output->right_menu = $thenThat;
        } else {
            
            // Create LEFT menu
            $menuMarkup = '';
            $menuMarkup .= '<div id="main-nav-left" class="medium-6">
                            <ul class="nav-menu">';
            
                    foreach( $firstThis as $item ) {

                        // Add subnav if there is one
                        if( $item->subnav ) {
                            $menuMarkup .= '<li class="menu-item-has-children">
                                            <a href="' .$item->url . '">' . $item->title . '</a>';

                                    $menuMarkup .= '<ul class="sub-menu">';
                                        foreach( $item->subnav as $subitem ) {

                                            // Add SECOND LEVEL subnav if there is one (deepest possible level)
                                            if( $subitem->subnav ) {
                                                $menuMarkup .= '<li class="menu-item-has-children">
                                                                <a href="' . $subitem->url . '">' . $subitem->title . '</a>';

                                                $menuMarkup .= '<ul class="sub-menu">';
                                                foreach( $subitem->subnav as $subsubitem ) {
                                                    $menuMarkup .= '<li><a href="' . $subsubitem->url . '">' . $subsubitem->title . '</a></li>';
                                                }
                                                $menuMarkup .= '</ul>';

                                            } else {
                                                $menuMarkup .= '<li><a href="' . $subitem->url .'">' . $subitem->title . '</a></li>';
                                            }
                                        }
                                    $menuMarkup .= '</ul>';

                        } else {
                            $menuMarkup .= '<li><a href="' .$item->url . '">' . $item->title . '</a>';
                        }
                        $menuMarkup .= '</li>';

                    }
                        
            $menuMarkup .= '</ul>
                            </div>';
            
            $output->left_menu = $menuMarkup;
            
            
            // Create RIGHT menu
            $menuMarkup = '';
            $menuMarkup .= '<div id="main-nav-right" class="medium-6">
                            <ul class="nav-menu">';
            
                    foreach( $thenThat as $item ) {

                        // Add subnav if there is one
                        if( $item->subnav ) {
                            $menuMarkup .= '<li class="menu-item-has-children">
                                            <a href="' .$item->url . '">' . $item->title . '</a>';

                                    $menuMarkup .= '<ul class="sub-menu">';
                                        foreach( $item->subnav as $subitem ) {

                                            // Add SECOND LEVEL subnav if there is one (deepest possible level)
                                            if( $subitem->subnav ) {
                                                $menuMarkup .= '<li class="menu-item-has-children">
                                                                <a href="' . $subitem->url . '">' . $subitem->title . '</a>';

                                                $menuMarkup .= '<ul class="sub-menu">';
                                                foreach( $subitem->subnav as $subsubitem ) {
                                                    $menuMarkup .= '<li><a href="' . $subsubitem->url . '">' . $subsubitem->title . '</a></li>';
                                                }
                                                $menuMarkup .= '</ul>';

                                            } else {
                                                $menuMarkup .= '<li class="no-subitem-i-guess"><a href="' . $subitem->url .'">' . $subitem->title . '</a></li>';
                                            }
                                        }
                                    $menuMarkup .= '</ul>';

                        } else {
                            $menuMarkup .= '<li><a href="' .$item->url . '">' . $item->title . '</a>';
                        }
                        $menuMarkup .= '</li>';

                    }
                        
            $menuMarkup .= '</ul>
                            </div>';
            
            $output->right_menu = $menuMarkup;
        }
        
        return $output;
        
    }
    
    else {
        
        echo '<em>' . __( 'Please select a menu for your Split navigation.', 'jkl') . '</em>';
        
    }
    
}

/**
 * Social Menu
 */
function jkl_social_menu() {
    
    if ( has_nav_menu( 'social' ) ) {
        wp_nav_menu(
                array(
                    'theme_location'    => 'social',
                    'container'         => 'div',
                    'container_id'      => 'menu-social-container',
                    'container_class'   => 'menu-social',
                    'menu_id'           => 'menu-social-items',
                    'menu_class'        => 'menu-items',
                    'depth'             => 1,
                    'link_before'       => '<span class="screen-reader-text">',
                    'link_after'        => '</span>',
                    'fallback_cb'       => '',
                )
        );
    }
    
}

/*
 * Validate Gravatar
 * @link: original: https://gist.github.com/justinph/5197810
 * @link: WP.org: http://codex.wordpress.org/Using_Gravatars#Checking_for_the_Existence_of_a_Gravatar
 */

/**
 * Utility function to check if a gravatar exists for a given email or id
 * @param int|string|object $id_or_email A user ID,  email address, or comment object
 * @return bool if the gravatar exists or not
 */

function jkl_validate_gravatar($id_or_email) {
  //id or email code borrowed from wp-includes/pluggable.php
	$email = '';
	if ( is_numeric($id_or_email) ) {
		$id = (int) $id_or_email;
		$user = get_userdata($id);
		if ( $user )
			$email = $user->user_email;
	} elseif ( is_object($id_or_email) ) {
		// No avatar for pingbacks or trackbacks
		$allowed_comment_types = apply_filters( 'get_avatar_comment_types', array( 'comment' ) );
		if ( ! empty( $id_or_email->comment_type ) && ! in_array( $id_or_email->comment_type, (array) $allowed_comment_types ) )
			return false;

		if ( !empty($id_or_email->user_id) ) {
			$id = (int) $id_or_email->user_id;
			$user = get_userdata($id);
			if ( $user)
				$email = $user->user_email;
		} elseif ( !empty($id_or_email->comment_author_email) ) {
			$email = $id_or_email->comment_author_email;
		}
	} else {
		$email = $id_or_email;
	}

	$hashkey = md5(strtolower(trim($email)));
	$uri = 'http://www.gravatar.com/avatar/' . $hashkey . '?d=404';

	$data = wp_cache_get($hashkey);
	if (false === $data) {
		$response = wp_remote_head($uri);
		if( is_wp_error($response) ) {
			$data = 'not200';
		} else {
			$data = $response['response']['code'];
		}
	    wp_cache_set($hashkey, $data, $group = '', $expire = 60*5);

	}		
	if ($data == '200'){
		return true;
	} else {
		return false;
	}
}



if ( ! function_exists( 'jkl_post_nav' ) ) :
/**
 * Display navigation to next/previous post when applicable.
 * 
 * Improve the post_nav() with post thumbnails. Help from this
 * @link: http://www.measureddesigns.com/adding-previous-next-post-wordpress-post/
 * @link: http://wpsites.net/web-design/add-featured-images-to-previous-next-post-nav-links/
 */
function jkl_post_nav() {
	// Don't print empty markup if there's nowhere to navigate.
	$previous = ( is_attachment() ) ? get_post( get_post()->post_parent ) : get_adjacent_post( false, '', true );
	$next     = get_adjacent_post( false, '', false );
        $prevID   = $previous ? $previous->ID : '';
        $nextID   = $next ? $next->ID : '';

	if ( ! $next && ! $previous ) {
		return;
	}
	?>
	<nav class="navigation post-navigation clear" role="navigation">
		<h2 class="screen-reader-text"><?php _e( 'Post navigation', 'jkl' ); ?></h2>
                
                <div class="nav-links">
                    <?php // My custom code below FIRST, then _s code
                    
                    // PREVIOUS POST LINK
                    if ( ! empty( $previous ) ) { ?>
                    <div class="nav-previous">
                        <a href="<?php echo get_permalink( $prevID ); ?>" rel="prev">
                    
                            <?php if ( ( has_post_thumbnail( $prevID ) && has_post_thumbnail( $nextID ) ) || ( has_post_thumbnail( $prevID ) && empty( $next ) ) ) { ?>
                                    <div class="post-nav-thumb">
                                        <?php $prev_thumb = get_the_post_thumbnail( $prevID, 'medium', array( 'class' => 'img-responsive' ) );
                                        echo $prev_thumb ? $prev_thumb : '<img src="http://localhost:8080/wordpress/wp-content/uploads/2012/08/cropped-keytokorean-logo2.png" />';
                                        ?>
                                    </div>
                            <?php } ?>
                    
                            <span class="meta-nav" aria-hidden="true"><?php _e( 'Previously', 'jkl' ); ?></span>
                            <span class="screen-reader-text"><?php _e( 'Previous Post', 'jkl' ); ?></span>
                            <span class="post-title"><?php echo $previous->post_title; ?></span>
                            
                        </a>
                    </div>
                    <?php } 
                    
                    // NEXT POST LINK
                    if ( ! empty( $next ) ) { ?>
                    <div class="nav-next">
                        <a href="<?php echo get_permalink( $nextID ); ?>" rel="next">
                    
                            <?php if ( get_the_post_thumbnail( $nextID ) && get_the_post_thumbnail( $nextID ) ) { ?>
                                    <div class="post-nav-thumb">
                                        <?php $next_thumb = get_the_post_thumbnail( $nextID, 'medium', array( 'class' => 'img-responsive' ) );
                                        echo $next_thumb ? $next_thumb : '<img src="http://localhost:8080/wordpress/wp-content/uploads/2012/08/cropped-keytokorean-logo2.png" />';
                                        ?>
                                    </div>
                            <?php } ?>
                    
                            <span class="meta-nav" aria-hidden="true"><?php _e( 'Next time', 'jkl' ); ?></span>
                            <span class="screen-reader-text"><?php _e( 'Next Post', 'jkl' ); ?></span>
                            <span class="post-title"><?php echo $next->post_title; ?></span>
                            
                        </a>
                    </div>
                    <?php } ?>
                    
                </div><!-- .nav-links -->
                    
                        <?php /*
				previous_post_link( '<div class="nav-previous large-6 columns">%link</div>', _x( '<span class="meta-nav">&larr;</span>&nbsp;%title', 'Previous post link', 'gojoseon' ) );
				next_post_link( '<div class="nav-next large-6 columns">%link</div>', _x( '%title&nbsp;<span class="meta-nav">&rarr;</span>', 'Next post link', 'gojoseon' ) );
			*/ ?>
                
	</nav><!-- .navigation -->
	<?php
}
endif;


/*
 * Customize the read-more indicator for excerpts
 */
function jkl_excerpt_more( $more ) {
    return " …";
}
add_filter( 'excerpt_more', 'jkl_excerpt_more' );


/*
 * Special Index Posted On Meta info for Index pages only
 */
if ( ! function_exists( 'jkl_index_posted_on' ) ) :
/**
 * Prints HTML with meta information for the current post-date/time and author.
 */
function jkl_index_posted_on() {
	$time_string = '<time class="entry-date published updated" datetime="%1$s">%2$s</time>';
	if ( get_the_time( 'U' ) !== get_the_modified_time( 'U' ) ) {
		$time_string = '<time class="entry-date published" datetime="%1$s">%2$s</time><time class="updated" datetime="%3$s">%4$s</time>';
	}

	$time_string = sprintf( $time_string,
		esc_attr( get_the_date( 'c' ) ),
		esc_html( get_the_date() ),
		esc_attr( get_the_modified_date( 'c' ) ),
		esc_html( get_the_modified_date() )
	);

	$posted_on = sprintf(
		esc_html_x( '%s', 'post date', 'jkl' ),
		'<a href="' . esc_url( get_permalink() ) . '" rel="bookmark">' . $time_string . '</a>'
	);

        echo '<div class="meta-content-index">';
	echo '<span class="posted-on">Date: ' . $posted_on . '</span>'; // WPCS: XSS OK. 
        echo '</div><!-- .meta-content-index -->';
}
endif;


if ( ! function_exists( 'jkl_paging_nav' ) ) :
/**
 * Display navigation to next/previous set of posts when applicable.
 *
 * @since Twenty Fourteen 1.0
 *
 * @global WP_Query   $wp_query   WordPress Query object.
 * @global WP_Rewrite $wp_rewrite WordPress Rewrite object.
 */
function jkl_paging_nav() {
	global $wp_query, $wp_rewrite;

	// Don't print empty markup if there's only one page.
	if ( $wp_query->max_num_pages < 2 ) {
		return;
	}

	$paged        = get_query_var( 'paged' ) ? intval( get_query_var( 'paged' ) ) : 1;
	$pagenum_link = html_entity_decode( get_pagenum_link() );
	$query_args   = array();
	$url_parts    = explode( '?', $pagenum_link );

	if ( isset( $url_parts[1] ) ) {
		wp_parse_str( $url_parts[1], $query_args );
	}

	$pagenum_link = remove_query_arg( array_keys( $query_args ), $pagenum_link );
	$pagenum_link = trailingslashit( $pagenum_link ) . '%_%';

	$format  = $wp_rewrite->using_index_permalinks() && ! strpos( $pagenum_link, 'index.php' ) ? 'index.php/' : '';
	$format .= $wp_rewrite->using_permalinks() ? user_trailingslashit( $wp_rewrite->pagination_base . '/%#%', 'paged' ) : '?paged=%#%';

	// Set up paginated links.
	$links = paginate_links( array(
		'base'     => $pagenum_link,
		'format'   => $format,
		'total'    => $wp_query->max_num_pages,
		'current'  => $paged,
		'mid_size' => 3,
		'add_args' => array_map( 'urlencode', $query_args ),
		'prev_text' => __( '&larr; Previous', 'jkl' ),
		'next_text' => __( 'Next &rarr;', 'jkl' ),
                'type'      => 'list',
	) );

	if ( $links ) :

	?>
	<nav class="navigation paging-navigation" role="navigation">
		<h1 class="screen-reader-text"><?php _e( 'Posts navigation', 'jkl' ); ?></h1>
                <?php echo $links; ?>
	</nav><!-- .navigation -->
	<?php
	endif;
}
endif;


if ( ! function_exists( 'jkl_breadcrumbs' ) ) :
/**
 * Display Post breadcrumbs when applicable.
 *
 * @since JKL 1.0
 * 
 * @link: https://www.thewebtaylor.com/articles/wordpress-creating-breadcrumbs-without-a-plugin
 */
function jkl_breadcrumbs() {
    
    if (!is_home()) {
        
        // Settings
        $separator          = '<span class="breadcrumb-separator">&raquo;</span>';
        $breadcrumb_id      = 'breadcrumbs';
        $breadcrumb_class   = 'breadcrumbs';
        $post               = get_post();
        
        if( is_category() || is_single() || ( is_page() && $post->post_parent ) ) {
        // Build the breadcrumbs
        echo "<div aria-label='You are here:' id='$breadcrumb_id' class='$breadcrumb_class'>";
		echo '<a aria-label="Home" title="Home" class="breadcrumb-home" href="';
		echo get_option('home');
		echo '"><span class="screen-reader-text">';
		bloginfo('name');
		echo "</span></a>$separator";
		//if ( (is_category() || is_single()) ) {
                
                $categories = get_the_category(/* array(
                    'orderby' => 'name',
                    'parent'  => 0
                ) */);
                $categories = array_slice( $categories, 0, 10 );
                
                foreach ( $categories as $category ) {
                    printf( '<a href="%1$s">%2$s</a>',
                        esc_url( get_category_link( $category->term_id ) ),
                        esc_html( $category->name )
                    );
                    echo $separator;
                }
			// the_category('<span class="breadcrumb-separator">&raquo;</span>');
                        //if (is_single()) {
			//	echo "$separator";
				// the_title();
			//}
		//} elseif (is_page()) {
			// echo the_title();
		//}
        echo '</div>';
        }
    }

    /*
    // Settings
    $separator          = '/';
    $breadcrumb_id      = 'breadcrumbs';
    $breadcrumb_class   = 'breadcrumbs';
    $home_title         = 'Home';
    
    // If there are custom taxonomies...
    $custom_tax         = 'taxonomy_name';
    
    // Get the query and post info
    global $post, $wp_query;
    
    // NOT on the homepage
    if ( !is_front_page() ) {
        
        // Build the breadcrumbs
        echo '<nav aria-label="You are here:" role="navigation">';
        echo '<ul id="' . $breadcrumb_id . '" class="' . $breadcrumb_class . '">';
        
        // Home page
        echo '<li class="item-home"><a class="bread-link bread-home" href="' . get_home_url() . '"title="' . $home_title . '">' . $home_title . '</a></li>';
        echo '<li class="separator separator-home"> ' . $separator . ' </li>';
        
        if ( is_archive() && !is_tax() && !is_category() && !is_tag() ) {
            
            echo '<li class="item-current item-archive"><strong class="bread-current bread-archive">' . post_type_archive_title( $prefix, false ) . '</strong></li>';
      
        } else if ( is_archive() && is_tax() && !is_category() && !is_tag() ) {
            
            // If a custom post type
            $post_type = get_post_type();
            
            if ( $post_type != 'post' ) {
                
                $post_type_object = get_post_type_object( $post_type );
                $post_type_archive = get_post_type_archive_link( $post_type );
                
                echo '<li class="item-cat item-custom-post-type-' . $post_type . '"><a class="bread-cat bread-custom-post-type-' . $post_type . '" href="' . $post_type_archive . '" title="' . $post_type_object->labels->name . '">' . $post_type_object->labels->name . '</a></li>';
                echo '<li class="separator"> ' . $separator . ' </li>';
                
            }
            
            // Get post category info
            $category = get_the_category();
            
            if( !empty( $category ) || empty( $category ) ) {
                
                // Get last category post is in
                $last_category = end( array_values( $category ) );
                
                // Get parent categories and create array
                $get_cat_parents = rtrim( get_category_parents( $last_category->term_id, true, ',' ), ',');
                $cat_parents = explode( ',', $get_cat_parents );
                
                // Loop through parent categories and store in variable $cat_display
                $cat_display = '';
                foreach( $cat_parents as $parents ) {
                    $cat_display .= '<li class="item-cat">' . $parents . '</li>';
                    $cat_display .= '<li class="separator"> ' . $separator . ' </li>';
                    
                }
                
                // If it's a custom post type within a custom taxonomy
                $taxonomy_exists = taxonomy_exists($custom_taxonomy);
                if(empty($last_category) && !empty($custom_taxonomy) && $taxonomy_exists) {

                    $taxonomy_terms = get_the_terms( $post->ID, $custom_taxonomy );
                    $cat_id         = $taxonomy_terms[0]->term_id;
                    $cat_nicename   = $taxonomy_terms[0]->slug;
                    $cat_link       = get_term_link($taxonomy_terms[0]->term_id, $custom_taxonomy);
                    $cat_name       = $taxonomy_terms[0]->name;

                }

                // Check if the post is in a category
                if(!empty($last_category)) {
                    echo $cat_display;
                    echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

                // Else if post is in a custom taxonomy
                } else if(!empty($cat_id)) {

                    echo '<li class="item-cat item-cat-' . $cat_id . ' item-cat-' . $cat_nicename . '"><a class="bread-cat bread-cat-' . $cat_id . ' bread-cat-' . $cat_nicename . '" href="' . $cat_link . '" title="' . $cat_name . '">' . $cat_name . '</a></li>';
                    echo '<li class="separator"> ' . $separator . ' </li>';
                    echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';

                } else {
                  
                    echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '" title="' . get_the_title() . '">' . get_the_title() . '</strong></li>';
                  
                }
                
            }
            
        } else if ( is_category() ) {
               
            // Category page
            echo '<li class="item-current item-cat"><strong class="bread-current bread-cat">' . single_cat_title('', false) . '</strong></li>';
               
        } else if ( is_page() ) {
               
            // Standard page
            if( $post->post_parent ){
                   
                // If child page, get parents 
                $anc = get_post_ancestors( $post->ID );
                   
                // Get parents in the right order
                $anc = array_reverse($anc);
                   
                // Parent page loop
                foreach ( $anc as $ancestor ) {
                    $parents .= '<li class="item-parent item-parent-' . $ancestor . '"><a class="bread-parent bread-parent-' . $ancestor . '" href="' . get_permalink($ancestor) . '" title="' . get_the_title($ancestor) . '">' . get_the_title($ancestor) . '</a></li>';
                    $parents .= '<li class="separator separator-' . $ancestor . '"> ' . $separator . ' </li>';
                }
                   
                // Display parent pages
                echo $parents;
                   
                // Current page
                echo '<li class="item-current item-' . $post->ID . '"><strong title="' . get_the_title() . '"> ' . get_the_title() . '</strong></li>';
                   
            } else {
                   
                // Just display current page if not parents
                echo '<li class="item-current item-' . $post->ID . '"><strong class="bread-current bread-' . $post->ID . '"> ' . get_the_title() . '</strong></li>';
                   
            }
               
        } else if ( is_tag() ) {
               
            // Tag page
               
            // Get tag information
            $term_id        = get_query_var('tag_id');
            $taxonomy       = 'post_tag';
            $args           = 'include=' . $term_id;
            $terms          = get_terms( $taxonomy, $args );
            $get_term_id    = $terms[0]->term_id;
            $get_term_slug  = $terms[0]->slug;
            $get_term_name  = $terms[0]->name;
               
            // Display the tag name
            echo '<li class="item-current item-tag-' . $get_term_id . ' item-tag-' . $get_term_slug . '"><strong class="bread-current bread-tag-' . $get_term_id . ' bread-tag-' . $get_term_slug . '">' . $get_term_name . '</strong></li>';
           
        } elseif ( is_day() ) {
               
            // Day archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month link
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><a class="bread-month bread-month-' . get_the_time('m') . '" href="' . get_month_link( get_the_time('Y'), get_the_time('m') ) . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('m') . '"> ' . $separator . ' </li>';
               
            // Day display
            echo '<li class="item-current item-' . get_the_time('j') . '"><strong class="bread-current bread-' . get_the_time('j') . '"> ' . get_the_time('jS') . ' ' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_month() ) {
               
            // Month Archive
               
            // Year link
            echo '<li class="item-year item-year-' . get_the_time('Y') . '"><a class="bread-year bread-year-' . get_the_time('Y') . '" href="' . get_year_link( get_the_time('Y') ) . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</a></li>';
            echo '<li class="separator separator-' . get_the_time('Y') . '"> ' . $separator . ' </li>';
               
            // Month display
            echo '<li class="item-month item-month-' . get_the_time('m') . '"><strong class="bread-month bread-month-' . get_the_time('m') . '" title="' . get_the_time('M') . '">' . get_the_time('M') . ' Archives</strong></li>';
               
        } else if ( is_year() ) {
               
            // Display year archive
            echo '<li class="item-current item-current-' . get_the_time('Y') . '"><strong class="bread-current bread-current-' . get_the_time('Y') . '" title="' . get_the_time('Y') . '">' . get_the_time('Y') . ' Archives</strong></li>';
               
        } else if ( is_author() ) {
               
            // Auhor archive
               
            // Get the author information
            global $author;
            $userdata = get_userdata( $author );
               
            // Display author name
            echo '<li class="item-current item-current-' . $userdata->user_nicename . '"><strong class="bread-current bread-current-' . $userdata->user_nicename . '" title="' . $userdata->display_name . '">' . 'Author: ' . $userdata->display_name . '</strong></li>';
           
        } else if ( get_query_var('paged') ) {
               
            // Paginated archives
            echo '<li class="item-current item-current-' . get_query_var('paged') . '"><strong class="bread-current bread-current-' . get_query_var('paged') . '" title="Page ' . get_query_var('paged') . '">'.__('Page') . ' ' . get_query_var('paged') . '</strong></li>';
               
        } else if ( is_search() ) {
           
            // Search results page
            echo '<li class="item-current item-current-' . get_search_query() . '"><strong class="bread-current bread-current-' . get_search_query() . '" title="Search results for: ' . get_search_query() . '">Search results for: ' . get_search_query() . '</strong></li>';
           
        } elseif ( is_404() ) {
               
            // 404 page
            echo '<li>' . 'Error 404' . '</li>';
        }
       
        echo '</ul></nav>';
           
    }*/
       
}
endif;