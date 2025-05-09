<?php
/**
 * Template part for including the new TOC in a template.
 */
// Start of code for new PHP Table of Contents.
// This is largely taken from the f70-simple-table-of-contents plugin, and modified.
function dt_anchor_content_h1_h6 ($content) {
    // Pattern that we want to match
    $pattern = "~<h(1|2|3|4|5|6)[^>]*>(.*?)</h(1|2|3|4|5|6)>~";

    // now run the pattern and callback function on content
    // and process it through a function that replaces the title with an id
    $hTags = array();
    $content = preg_replace_callback($pattern, function ($matches) {
        $tag = $matches[1];
        $title = $matches[2];
        $slug = "id-" . sanitize_title_with_dashes($title, '', 'save');
        return "<h{$matches[1]} id='$slug" ."'>" . $title . "</h{$matches[1]}>";
    }, $content);
    return $content;
 }
add_filter('the_content', 'dt_anchor_content_h1_h6');

       function get_toc_link( $header ) {
                if( $header[ 'page' ] <= 1 ){
                        return '#' . $header[ 'anchor_name' ];

                } else {

                        if ( ! get_option( 'permalink_structure' ) ) {
                                return add_query_arg( 'page', $header[ 'page' ], get_permalink() ) . '#' . $header[ 'anchor_name' ];
                        } else {
                                return trailingslashit( get_permalink() ) . $header[ 'page' ] . '#' . $header[ 'anchor_name' ];
                        }

                }
        }
        function get_headings(){
                global $post;
                $headers = array();

                if ( strpos( $post->post_content, '<h2' ) === false ) {
                        return $headers;
                }

                $html = apply_filters( 'the_content', get_the_content() );

                $lines = explode( "\n", $html );

                if( empty( $lines ) ) {
                        return $headers;
                }

                $page = 1;
                $j = 1;
                foreach ( $lines as $line ) {
                        $array = array(
                                'anchor_name' => '',
                                'title_str'     =>      '',
                                'head'  =>      '',
                                'match_str' =>  '',
                                'page'  =>      '',
                        );

                        if ( strpos( $line, '<!--nextpage-->' ) !== false ) {
                                $page ++;
                                continue;
                        }
                        if( preg_match( '/<h[2|4].*?>(.*?)<\/h[2|4]>/', $line, $matches ) ) {

                                $array[ 'page' ] = $page;
                                $array[ 'title_str' ] = strip_tags($matches[1]);
                                $array[ 'match_str' ] = trim( $matches[0] );
                                $string_to_test = $matches[0];

                                if ( stristr( $matches[0], '<h2' ) !== FALSE ) {
                                        $array['head'] = 2;
                                } elseif ( stristr( $matches[0], '<h4' ) !== FALSE ) {
                                        $array['head'] = 4;
                                }

                                // This preg_match is not working on $matches[0]. Not clear why as it works on PHP CLI.
                                if ( preg_match('/id=\"(.*?)\"/', $matches[0], $matches_id) ) {
                                        $array[ 'anchor_name' ] = $matches_id[1];
                                } else {
                                      $array[ 'anchor_name' ] = "id-" . sanitize_title_with_dashes($array[ 'title_str' ], '', 'save');
                                      //  $array[ 'anchor_name' ] = 'index' . $j;
                                }
                                $headers[] = $array;
                                $j ++;
                        }
                }

                return $headers;
        }
        function make_table( $content, $add_h4 = true ) {
                global $post;

                $headers = get_headings();
                if ( empty( $headers ) ) { return; }

                $array_h2 = array();
                $array_h4 = array();
                $x = 0;
                $p = 0;
                foreach ( $headers as $header ) {
                        if ( $header['head'] == 2 ) {
                                $x ++;
                                $array_h2[$x] = $header;
                        }
                        if ( $header['head'] == 4 ) {
                                $array_h4[$x][] = $header;
                        }
                        $p ++;
                }

                if ( !empty( $array_h2 ) ) {
                        $y = 1;
                        $i = 1;

                        $add_class = '';
                        if ( $add_h4 ) {
                                $add_class = ' add_h4';
                        }

                        $mokuji_str = '<aside id="toc" class="table-of-contents' . $add_class . '"><h3>' . __( 'Table of contents', 'table-of-contents' ) . '</h3>';
                        $mokuji_str .= '';
                        foreach ( $array_h2 as $h2 ) {
                                $link = get_toc_link( $h2 );
                                $mokuji_str .= '<details name="toc-section"><summary class="toc-main"><a href="' . $link . '" class="toc-link"><h4>' . $h2[ 'title_str' ] . '</h4></a>';

                                $i ++;

                                if ( !empty( $array_h4[$y] ) && $add_h4 ) {
                                  $mokuji_str .= '<div class="toc-navigation-icon"><svg viewBox="0 0 23 13" fill="none" xmlns="http://www.w3.org/2000/svg">
<path d="M1.6 1.5l9.9 9.9 9.9-9.9" stroke="#6e7ca0" stroke-width="2"></path></svg>
</div></summary>';
                                } else {
                                  $mokuji_str .= '</summary>';
                                }
                                if ( !empty( $array_h4[$y] ) && $add_h4 ) {
                                        $h4ul = '';
                                        foreach ( $array_h4[$y] as $h4 ) {
                                                $link = get_toc_link( $h4 );
                                                $h4ul .= '<a href="' . $link . '" class="toc-sublink"><h5>' . $h4['title_str'] . '</h5></a>'."\n";
                                                $i ++;
                                        }
                                        $mokuji_str .= $h4ul;
                                }
                                $mokuji_str .= '</details>'."\n";
                                $y ++;
                        }
                        $mokuji_str .= '</aside>';
                }
                return $mokuji_str;
}
                

?>
