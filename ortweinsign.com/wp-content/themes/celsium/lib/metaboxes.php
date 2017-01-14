<?php

    $__METABOXES = array(

        'afl_metabox_composer_base' => array(
            'title'	=> __('Content composer', $domain),
            'page'	=> array('page'),
            'context'	=> 'normal',
            'priority'	=> 'high',
            'output'    => '__afl_composer_base'
        ),
        'afl_metabox_cloner' => array(
            'title'	=> __('Clone content', $domain),
            'page'	=> array('page'),
            'context'	=> 'side',
            'priority'	=> 'core',
            'output'    => '__afl_cloner'
        ),
    );


    function afl_add_metabox_hook(){
        global $__METABOXES;
        foreach($__METABOXES as $id => $mb){
            if (is_array($mb['page'])){
                foreach($mb['page'] as $page){
                    add_meta_box($id, $mb['title'], $mb['output'], $page, $mb['context'], $mb['priority'], $mb);
                }
            }
            else{
                add_meta_box($id, $mb['title'], $mb['output'], $mb['page'], $mb['context'], $mb['priority'], $mb);
            }
        }
    }
    add_action('admin_init', 'afl_add_metabox_hook', 1);


    function afl_save_metabox_hook( $post_id ){
        // verify if this is an auto save routine.
        // If it is our form has not been submitted, so we dont want to do anything
        if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE )
            return $post_id;

        // Check permissions
        if ( !current_user_can( 'edit_'.$_POST['post_type'], $post_id ) ){
            return $post_id;
        }

        if(isset($_POST['afl_composer'])){
            update_post_meta($post_id, 'afl_composer', $_POST['afl_composer']);
            $composer_data = array();
            if(isset($_POST['itemtype'])){
                foreach( $_POST['itemtype'] as $i => $v ){
                    $data = unserialize(base64_decode(stripslashes($_POST['itemdata'][$i])));

                    if($v == 'thumbnail-slider' || $v == 'cool-slider'){
                        //make thumbs
                        if (is_array($data["{$v}_images"])){
                            foreach ($data["{$v}_images"] as &$image){
                                //convert url to file path
                                $file_path = ABSPATH.str_replace(get_option('siteurl'), '', $image['url']);
                                if(file_exists($file_path)){
                                    $pi = pathinfo($file_path);
                                    $thumb_path = image_resize($file_path,110,72,true,'nivo-thunb');
                                    $image['thumb'] = $thumb_url = get_option('siteurl').str_replace(ABSPATH, '', $thumb_path);
                                }
                            }
                        }
                    }
                    $item = array('type' => stripslashes($v), 'name'=>stripslashes($_POST['itemname'][$i]), 'prefix' => stripslashes($_POST['itemprefix'][$i]), 'suffix' => stripslashes($_POST['itemsuffix'][$i]), 'data' => $data);
                    if(!empty($composer_data)&&isset($composer_data[count($composer_data)-1]['attached'])){
                        if(!empty($_POST['itemattached'][$i])){
                            $composer_data[count($composer_data)-1]['attached'][] = $item;
                            continue;
                        }
                    }
                    if($v == 'sidebar'){
                        $item['attached'] = array();
                    }

                    $composer_data[] = $item;

                }

            }
            $pid = (($pid = wp_is_post_revision($post_id))?$pid:$post_id);
            afl_set_te_data($pid, $composer_data);

        }
        $pid = wp_is_post_revision($post_id);
        if(!empty($_POST['afl_clone'])&&intval($_POST['post_ID'])===$pid){
            $p = get_post($pid);
            if($p){
                unset($p->ID);
                unset($p->guid);
                unset($p->post_date);
                unset($p->post_date_gmt);
                unset($p->post_modified_gmt);
                unset($p->comment_count);
                $p->post_title = $p->post_title.__('(Cloned)',$domain);
                $p->ID = wp_insert_post($p);
                if($p->ID>0){
                    wp_redirect(admin_url("post.php?post={$p->ID}&action=edit"));exit;
                }
            }
        }
    }

    add_action('save_post', 'afl_save_metabox_hook');	

?>