<?php
/**
 * Custom functions that act independently of the theme templates.
 *
 * Eventually, some of the functionality here could be replaced by core features.
 *
 * @package bellaworks
 */

/**
 * Adds custom classes to the array of body classes.
 *
 * @param array $classes Classes for the body element.
 * @return array
 */
define('THEMEURI',get_template_directory_uri() . '/');
function bellaworks_body_classes( $classes ) {
    // Adds a class of group-blog to blogs with more than 1 published author.
    if ( is_multi_author() ) {
        $classes[] = 'group-blog';
    }

    // Adds a class of hfeed to non-singular pages.
    if ( ! is_singular() ) {
        $classes[] = 'hfeed';
    }

    if ( is_front_page() || is_home() ) {
        $classes[] = 'homepage';
    } else {
        $classes[] = 'subpage';
    }

    $browsers = ['is_iphone', 'is_chrome', 'is_safari', 'is_NS4', 'is_opera', 'is_macIE', 'is_winIE', 'is_gecko', 'is_lynx', 'is_IE', 'is_edge'];
    $classes[] = join(' ', array_filter($browsers, function ($browser) {
        return $GLOBALS[$browser];
    }));

    return $classes;
}
add_filter( 'body_class', 'bellaworks_body_classes' );

if( function_exists('acf_add_options_page') ) {
    acf_add_options_page();
}


function add_query_vars_filter( $vars ) {
  $vars[] = "pg";
  return $vars;
}
add_filter( 'query_vars', 'add_query_vars_filter' );


function shortenText($string, $limit, $break=".", $pad="...") {
  // return with no change if string is shorter than $limit
  if(strlen($string) <= $limit) return $string;

  // is $break present between $limit and the end of the string?
  if(false !== ($breakpoint = strpos($string, $break, $limit))) {
    if($breakpoint < strlen($string) - 1) {
      $string = substr($string, 0, $breakpoint) . $pad;
    }
  }

  return $string;
}

/* Fixed Gravity Form Conflict Js */
add_filter("gform_init_scripts_footer", "init_scripts");
function init_scripts() {
    return true;
}

function get_page_id_by_template($fileName) {
    $page_id = 0;
    if($fileName) {
        $pages = get_pages(array(
            'post_type' => 'page',
            'meta_key' => '_wp_page_template',
            'meta_value' => $fileName.'.php'
        ));

        if($pages) {
            $row = $pages[0];
            $page_id = $row->ID;
        }
    }
    return $page_id;
}

function string_cleaner($str) {
    if($str) {
        $str = str_replace(' ', '', $str); 
        $str = preg_replace('/\s+/', '', $str);
        $str = preg_replace('/[^A-Za-z0-9\-]/', '', $str);
        $str = strtolower($str);
        $str = trim($str);
        return $str;
    }
}

function format_phone_number($string) {
    if(empty($string)) return '';
    $append = '';
    if (strpos($string, '+') !== false) {
        $append = '+';
    }
    $string = preg_replace("/[^0-9]/", "", $string );
    $string = preg_replace('/\s+/', '', $string);
    return $append.$string;
}

function get_instagram_setup() {
    global $wpdb;
    $result = $wpdb->get_row( "SELECT option_value FROM $wpdb->options WHERE option_name = 'sb_instagram_settings'" );
    if($result) {
        $option = ($result->option_value) ? @unserialize($result->option_value) : false;
    } else {
        $option = '';
    }
    return $option;
}

function extract_emails_from($string){
  preg_match_all("/[\._a-zA-Z0-9-]+@[\._a-zA-Z0-9-]+/i", $string, $matches);
  return $matches[0];
}

function email_obfuscator($string) {
    $output = '';
    if($string) {
        $emails_matched = ($string) ? extract_emails_from($string) : '';
        if($emails_matched) {
            foreach($emails_matched as $em) {
                $encrypted = antispambot($em,1);
                $replace = 'mailto:'.$em;
                $new_mailto = 'mailto:'.$encrypted;
                $string = str_replace($replace, $new_mailto, $string);
                $rep2 = $em.'</a>';
                $new2 = antispambot($em).'</a>';
                $string = str_replace($rep2, $new2, $string);
            }
        }
        $output = apply_filters('the_content',$string);
    }
    return $output;
}

function get_social_links() {
    $social_types = social_icons();
    $social = array();
    foreach($social_types as $k=>$icon) {
        $value = get_field($k,'option');
        if($value) {
            $social[$k] = array('link'=>$value,'icon'=>$icon);
        }
    }
    return $social;
}

function social_icons() {
    $social_types = array(
        'facebook'  => 'fab fa-facebook-f',
        'twitter'   => 'fab fa-twitter',
        'linkedin'  => 'fab fa-linkedin-in',
        'instagram' => 'fab fa-instagram',
        'youtube'   => 'fab fa-youtube',
        'snapchat'  => 'fab fa-snapchat-ghost',
    );
    return $social_types;
}

function parse_external_url( $url = '', $internal_class = 'internal-link', $external_class = 'external-link') {

    $url = trim($url);

    // Abort if parameter URL is empty
    if( empty($url) ) {
        return false;
    }

    //$home_url = parse_url( $_SERVER['HTTP_HOST'] );     
    $home_url = parse_url( home_url() );  // Works for WordPress

    $target = '_self';
    $class = $internal_class;

    if( $url!='#' ) {
        if (filter_var($url, FILTER_VALIDATE_URL)) {

            $link_url = parse_url( $url );

            // Decide on target
            if( empty($link_url['host']) ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } elseif( $link_url['host'] == $home_url['host'] ) {
                // Is an internal link
                $target = '_self';
                $class = $internal_class;

            } else {
                // Is an external link
                $target = '_blank';
                $class = $external_class;
            }
        } 
    }

    // Return array
    $output = array(
        'class'     => $class,
        'target'    => $target,
        'url'       => $url
    );

    return $output;
}

function get_images_from_website($imageURL) {
    $url_to_image = $imageURL;
    $dir = wp_get_upload_dir();
    $path = $dir['path'];
    $parts = explode("uploads/",$path);
    $uploadsDIR = $parts[0] . 'uploads/imports/';

    $ch = curl_init($url_to_image);
    $my_save_dir = $uploadsDIR;
    $filename = basename($url_to_image);
    $complete_save_loc = $my_save_dir . $filename;
    $fp = fopen($complete_save_loc, 'wb');
    curl_setopt($ch, CURLOPT_FILE, $fp);
    curl_setopt($ch, CURLOPT_HEADER, 0);
    curl_exec($ch);
    curl_close($ch);
    fclose($fp);
    return ( file_exists($complete_save_loc) ) ?  $complete_save_loc : '';
}

add_action( 'init', 'extractdata' );
function extractdata() {
   wp_register_script( "extractdata", get_stylesheet_directory_uri() . '/assets/js/extract.js', array('jquery') );
   wp_localize_script( 'extractdata', 'myAjax', array( 'ajaxurl' => admin_url( 'admin-ajax.php' )));        
   wp_enqueue_script( 'jquery' );
   wp_enqueue_script( 'extractdata' );
}


add_action( 'wp_ajax_nopriv_extract_data_from_website', 'extract_data_from_website' );
add_action( 'wp_ajax_extract_data_from_website', 'extract_data_from_website' );
function extract_data_from_website() {
    if(!empty($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        $objects = ($_POST['objects']) ? $_POST['objects'] : '';
        $post_type = ($_POST['posttype']) ? $_POST['posttype'] : '';
        $imagesUploaded = array();
        $file_uploads = '';
        $file_info = array();
        if($objects) {
            foreach($objects as $obj) {
                $title = $obj['title'];
                $imageURL = $obj['image'];
                $path = get_images_from_website($imageURL);
                if($path) {
                    $imagesUploaded[] = $imageURL;
                    $file_uploads .= $imageURL.'<br>';
                    $name = basename($imageURL);
                    $filename = 'imports/' . $name;
                    $file_info[] = array(
                                'title'=>'',
                                'category'=>$title,
                                'image_url'=>$filename,
                                'filename'=>$name,
                                'website'=>''
                            );
                }
            }
        }

        if($file_info) {
            $json = json_encode($file_info,JSON_PRETTY_PRINT);
            $dir = wp_get_upload_dir();
            $path = $dir['path'];
            $parts = explode("uploads/",$path);
            $file = $parts[0] . 'uploads/imports/data.json';
            $myfile = fopen($file, "w") or die("Unable to open file!");
            $txt = $json;
            fwrite($myfile, $txt);
            fclose($myfile);
        }
        $response['uploaded'] = ($imagesUploaded) ? $imagesUploaded : '';
        $message = '';
        if($file_uploads) {
            $message = '<div class="alert alert-success">'.$file_uploads.'</div>';
        }
        $response['message'] = $message;
        echo json_encode($response);
    }
    else {
        header("Location: ".$_SERVER["HTTP_REFERER"]);
    }
    die();
}

function search_attachment($filename) {
    global $wpdb;
    if(empty($filename)) return '';
    $parts = pathinfo($filename);
    $title =  trim($parts['filename']);
    $query = "SELECT * FROM {$wpdb->prefix}posts WHERE post_title='".$title."' AND post_type='attachment'";
    $result = $wpdb->get_row($query);
    return ($result) ? $result->ID : '';
}

function get_data_json_file() {
    $jsonfile = get_import_dir() . 'data.json';
    return $jsonfile;
}

function get_import_dir() {
    $dir = wp_get_upload_dir();
    $path = $dir['path'];
    $parts = explode("uploads/",$path);
    return $parts[0] . 'uploads/imports/';
}

function get_term_info($slug) {
    global $wpdb;
    $query = "SELECT * FROM {$wpdb->prefix}terms WHERE slug='".$slug."'";
    $result = $wpdb->get_row($query);
    return ($result) ?  $result : '';
}

function assigned_term_to_post($post_id,$term_id) {
    global $wpdb;
    $relationships = $wpdb->prefix.'term_relationships';
    $ok = $wpdb->insert($relationships, array(
        'object_id' => $post_id,
        'term_taxonomy_id' => $term_id,
    ));
    return ($ok) ? $ok : '';
}

function get_news_filter_options() {
    global $wpdb;
    $output = array();
    
    // Year
    $years = array();
    $year_result = $wpdb->get_results("SELECT ID, YEAR(post_date) AS year FROM ".$wpdb->prefix."posts WHERE post_type='post' AND post_status='publish' GROUP BY YEAR(post_date) ORDER BY year DESC");
    if($year_result) {
        foreach($year_result as $r) {
            $yr = $r->year;
            $years[$yr] = $yr;
        }
        $output[] = array('label'=>'Year','slug'=>'yr','items'=>$years);
    }

    // Month
    $months = array();
    $month_result = $wpdb->get_results("SELECT ID, post_date, MONTH(post_date) AS month FROM ".$wpdb->prefix."posts WHERE post_type='post' AND post_status='publish' GROUP BY MONTH(post_date) ORDER BY month ASC");
    if($month_result) {
        foreach($month_result as $r) {
            $monthNum = $r->month;
            $dateObj = DateTime::createFromFormat('!m', $monthNum); 
            $monthName = $dateObj->format('F'); 
            $months[$monthNum] = $monthName;
        }

        $output[] = array('label'=>'Month','slug'=>'mo','items'=>$months);
    }

    //Vendors
    $vendors = array();
    $vendors_result = $wpdb->get_results("SELECT p.ID, m.meta_value FROM ".$wpdb->prefix."posts AS p, ".$wpdb->prefix."postmeta AS m WHERE p.ID=m.post_id AND p.post_type='post' AND p.post_status='publish' AND m.meta_key='partners' GROUP BY p.ID");
    if($vendors_result){
        foreach( $vendors_result as $v ) {
            $metaVal = $v->meta_value;
            if($metaVal) {
                $data = @unserialize($metaVal);
                if($data) {
                    $id = $data[0];
                    $partner = get_the_title($id);
                    $vendors[$id] = array('ID'=>$id,'post_title'=>$partner,'slug'=>sanitize_title($partner));
                }
            }
        }
        $vendorArrs = array_values($vendors);
        $vendors_sorted = sortArray($vendorArrs,'slug','ASC');
        $vendorList = array();
        foreach($vendors_sorted as $v) {
            $i = $v['ID'];
            $vendorList[$i] = $v['post_title'];
        }

        $output[] = array('label'=>'Vendor','slug'=>'vendor','items'=>$vendorList);
    }

    return $output;
}

function get_news_result_filter_by($params) {
    $output = array();
    global $wpdb;
    $year = ( isset($params['yr']) && $params['yr'] ) ? $params['yr'] : '';
    $month = ( isset($params['mo']) && $params['mo'] ) ? $params['mo'] : '';
    $vendor = ( isset($params['vendor']) && $params['vendor'] ) ? $params['vendor'] : '';
    $perpage = ( isset($params['perpage']) && $params['perpage'] ) ? $params['perpage'] : 9;
    $paged = ( isset($params['paged']) && $params['paged'] ) ? $params['paged'] : 1;
    $records = array();
    $query = "SELECT p.*, YEAR(p.post_date) AS year, MONTH(p.post_date) AS month FROM ".$wpdb->prefix."posts p WHERE p.post_type='post' AND p.post_status='publish'";
    
    if($year) {
        $query .= " AND YEAR(p.post_date)=" . $year;
    }
    if($month) {
        $query .= " AND MONTH(p.post_date)=" . $month;
    }

    $query .= " ORDER BY p.post_date DESC";

    $result = $wpdb->get_results($query);
    if($result) {
        foreach($result as $row) {
            $id = $row->ID;
            if($vendor) {
                $partners = get_field("partners",$id); /* ACF meta field */
                if($partners) {
                    foreach($partners as $p) {
                        $row->partner_id = $p;
                        if($p==$vendor) {
                            $records[$id] = $row;
                        }
                    }
                }
            } else {
                $records[$id] = $row;
            }
        }
    }

    $final_result = array();
    $total = ($records) ? count($records) : 0;

    if($records)  {
        $posts = array_values($records);
        $start = 0;
        $end = $perpage - 1;
        if($paged>1) {
            $start = ($paged * $perpage) - $perpage;
            $end  = ($paged * $perpage) - 1;
        }

        for( $i=$start; $i<=$end; $i++ ) {
            if( isset($posts[$i]) && $posts[$i] ) {
                $final_result[$i] = $posts[$i];
            }
        }
    }

    if($final_result) {
        $output['total'] = $total;
        $output['posts'] = $final_result;
        return $output;
    } else {
        return false;
    }
    
}

function sortArray($array, $sortByKey, $sortDirection) {

    $sortArray = array();
    $tempArray = array();

    foreach ( $array as $key => $value ) {
        $tempArray[] = trim(strtolower( $value[ $sortByKey ] ));
    }

    if($sortDirection=='ASC'){
        sort($tempArray);
    } else {
        rsort($tempArray);
    }

    foreach($tempArray as $k=>$val) {
        foreach($array as $a=>$b) {
            $ref = $b[$sortByKey];
            if($ref==$val) {
                $sortArray[$k] = $b;
            }
        }
    }

    return $sortArray;
}




