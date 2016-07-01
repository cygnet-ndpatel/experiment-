<?php

$terms = get_terms('seller_category' , array(
 	'orderby'    => 'none',
 	'hide_empty' => 0
));

if( ! empty( $terms ) && ! is_wp_error( $terms ) )
{
   foreach ( $terms as $term )
   {


$catTerms = get_terms('category' , array(
 	'orderby'    => 'none',
 	'hide_empty' => 0
));

foreach ( $catTerms as $cams )
{
$flag = 0;
if( $cams->name == $term->name )
{
$flag = 1;
}
}
if($flag == 0)
{
            $termchildren = get_term_children($term->term_id, 'seller_category');
            if( ! empty( $termchildren ))
	    {	    	
                $insert_id = wp_insert_term( $term->name, 'category');
	    	foreach ( $termchildren as $child )
                {
				$childterm = get_term_by( 'id', $child, 'seller_category' );
				$my_cat = array( 'parent'=> $insert_id['term_id'] );
				$insert_child_id = wp_insert_term( $childterm->name, 'category', $my_cat );
                                $termsubchildren = get_term_children($insert_child_id, 'seller_category');
                                if( ! empty( $termchildren ))
	                        {
addchild($termsubchildren, $insert_child_id);
}
			}

	    
	    }
	    else
	    {
	    	
$alldetail =  get_term_by( 'id', $term->term_id , 'seller_category' );
if($alldetail->parent)
{
$xyz = addparent($childterm->parent);

}
	    }
    }
}
}

function addparent($parent)
{
$ccterm = get_term( $parent, 'seller_category' );
$my_cat = array( 'parent'=> $parent );
$insert_child_ = wp_insert_term( $ccterm->name, 'category' );

$subchildterm = get_term_by( 'id', $parent , 'seller_category' );
if($subchildterm->parent)
{
    addparent($subchildterm->parent);
}
else
{
return false;
}
}

function addchild($childarray, $parentId)
{
$childterm = get_term_by( 'id', $childarray, 'seller_category' );
$my_cat = array( 'parent'=> $parentId['term_id'] );
				$insert_child_id =wp_insert_term( $childterm->name, 'category', $my_cat );
                                $termsubchildren = get_term_children($insert_child_id, 'seller_category');
                                if( ! empty( $termchildren ))
	                        {
addchild($termsubchildren, $insert_child_id );
}
}

?>