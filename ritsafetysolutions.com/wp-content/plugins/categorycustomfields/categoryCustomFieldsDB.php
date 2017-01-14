<?php function categoryCustomFields_DB_UpdateFields($name,$value,$term_id){	global $wpdb;	$table_values=$wpdb->prefix . "ccf_Value";	$row =categoryCustomFields_DB_GetCategoryValueById($term_id,$name);	if($row->term_id!=$term_id)			$sql= "insert into $table_values (field_name,field_value,term_id) values ('".$name."','".$value."',$term_id);";	else		$sql= "update $table_values set field_value='".$value."' where term_id=$term_id and field_name='".$name."'";	$wpdb->query($sql);}function categoryCustomFields_DB_GetCategoryValueById($term_id,$name){	global $wpdb;	$table_values=$wpdb->prefix . "ccf_Value";	$table_setting=$wpdb->prefix . "ccf_Fields";	$sql="select term_id,field_value,v.field_name,field_type	from 		$table_values  v	inner join		$table_setting s	on		v.field_name = s.field_name		where term_id=$term_id and v.field_name='".$name."'";		return $wpdb->get_row($sql);}function categoryCustomFields_DB_GetCategoryValueByTaxonomy($term_id){	global $wpdb;	$table_values=$wpdb->prefix . "ccf_Value";	$table_setting=$wpdb->prefix . "ccf_Fields";		$sql="	select 				term_id,				field_value,				v.field_name ,				field_type,				category_type		    from 				$table_values v			inner join				$table_setting s			on				v.field_name = s.field_name				where 				term_id=$term_id";		return $wpdb->get_results($sql);}function categoryCustomFields_DB_GetFields($taxonomy){	global $wpdb;	if($taxonomy != 'category') $taxonomy='taxonomy';	$table_setting=$wpdb->prefix . "ccf_Fields";	$sql = "select		field_name,		category_type,		field_type	from		$table_setting	where 		category_type='".$taxonomy."' 	or 		category_type='Both'";	return $wpdb->get_results($sql);}function categoryCustomFields_DB_GetTaxonomyNameTermById($termId){	global $wpdb;	$table_taxonomy = $wpdb->prefix.'term_taxonomy';	$table_terms= $wpdb->prefix.'terms';	$table_terms_rel = $wpdb->prefix.'term_relationships';		$sql="select 			taxonomy		from			$table_taxonomy as t		where 			term_id=$termId";	return $wpdb->get_var($sql);		}function categoryCustomFields_DB_DeleteCategory($catField){	global $wpdb;	$table_values=$wpdb->prefix . "ccf_Value";	$table_setting=$wpdb->prefix . "ccf_Fields";		$sql = "delete from $table_values where field_name='$catField'";	$wpdb->query($sql);	$sql = "delete from $table_setting where field_name='$catField'";	$wpdb->query($sql);	}function categoryCustomFields_DB_UpdateCategory($catField,$newName){	global $wpdb;	$table_values=$wpdb->prefix . "ccf_Value";	$table_setting=$wpdb->prefix . "ccf_Fields";		$sql = "update $table_values set field_name=$newName where field_name=$catField";	$wpdb->query($sql);	$sql = "update $table_setting set field_name=$newName where field_name=$catField";	$wpdb->query($sql);}function categoryCustomFields_DB_GetPostsByCustomField($fieldName,$fieldValue){	global $wpdb;	global $post;	$table_values=$wpdb->prefix . "ccf_Value";	$table_setting=$wpdb->prefix . "ccf_Fields";	$sql = "	SELECT wposts.* 	FROM $wpdb->posts wposts		LEFT JOIN $wpdb->term_relationships ON (wposts.ID = $wpdb->term_relationships.object_id)		LEFT JOIN $wpdb->term_taxonomy ON ($wpdb->term_relationships.term_taxonomy_id = $wpdb->term_taxonomy.term_taxonomy_id)		INNER JOIN $table_values ON $table_values.term_id=$wpdb->term_taxonomy.term_id	WHERE 		$table_values.field_name='$fieldName'	AND		$table_values.field_value='$fieldValue'	AND		wposts.post_parent = 0	";			return $wpdb->get_results($sql);}function categoryCustomFields__DB_GetCategoriesByCustomField($fieldName,$fieldValue){	global $wpdb;	global $post;	$table_values=$wpdb->prefix . "ccf_Value";	$table_setting=$wpdb->prefix . "ccf_Fields";	$sql = "	SELECT wterms.* 	FROM $wpdb->terms wterms		INNER JOIN $table_values ON $table_values.term_id=wterms.term_id	WHERE 		$table_values.field_name='$fieldName'	AND		$table_values.field_value='$fieldValue'		";			return $wpdb->get_results($sql);}function categoryCustomFields__DB_GetCategoryCustomField($catID,$fieldName){	global $wpdb;	global $post;	$table_values=$wpdb->prefix . "ccf_Value";	$table_setting=$wpdb->prefix . "ccf_Fields";	$sql = "	SELECT *	FROM $table_values 	WHERE 		$table_values.field_name='$fieldName'	AND		$table_values.term_id=$catID		";		return $wpdb->get_results($sql);}?>