<?php
	//global $taxonomyName, $customTaxName;
	$taxonomyName = 'writer';
	$customTaxName = 'category';

	$customTaxTerms = get_terms($taxonomyName , array(
					 	'orderby'    => 'none',
					 	'hide_empty' => 0,
					 	'parent'     => 0
					));
	if(! empty( $customTaxTerms ) && ! is_wp_error( $customTaxTerms ))
	{
		foreach ( $customTaxTerms as $term )
		{
			$insert_id = wp_insert_term( $term->name, $customTaxName);
			$customTaxtChildTerm = get_terms($taxonomyName , array(
					 	'orderby'    => 'none',
					 	'hide_empty' => 0,
					 	'parent'     => $term->term_id
					));
			if( ! empty( $customTaxtChildTerm ))
			{
				addchild($customTaxtChildTerm, $insert_id, $taxonomyName, $customTaxName);
			}
		}
	}

function addchild($childarray, $parentId, $taxonomyName, $customTaxName)
{
	foreach($childarray as $childTerms)
    {
		$childterm = get_term_by( 'id', $childTerms->term_id, $taxonomyName );
		$my_cat = array( 'parent'=> $parentId['term_id'] );
		$insert_child_id = wp_insert_term( $childterm->name, $customTaxName, $my_cat );
		$termsubchildren = get_terms($taxonomyName , array(
				 	'orderby'    => 'none',
				 	'hide_empty' => 0,
				 	'parent'     => $childterm->term_id
				));
	    if( ! empty( $termsubchildren ))
		{
			addchild($termsubchildren, $insert_child_id, $taxonomyName, $customTaxName);
		}
	}
}
?>