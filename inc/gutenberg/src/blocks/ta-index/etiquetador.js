import React, { useState, useEffect, useRef } from "react";
import TAEtiquetador from '../../components/TAEtiquetador/TAEtiquetador';
import RBTagsManager from '../../components/RBTagsManager/RBTagsManager';
import {useRbTerms} from '../../helpers/rb-terms/rb-terms.js';
import {
	get,
	map,
} from 'lodash';
const { withSelect, withDispatch } = wp.data;
const { compose } = wp.compose;

function postScreenTermsSelector( OriginalComponent ) {
    return function( props = {} ) {
        const {
            slug: taxonomy,
            taxonomy: taxonomyData,
            terms,
            onUpdateTerms,
        } = props;

        if ( taxonomy !== 'ta_article_tag' )
            return <OriginalComponent {...props} />;

        return (
            <>
				<TATagsManager
					{...props}
				    taxonomy = { taxonomyData }
				    slug = { taxonomy }
				/>
            </>
        );
    };
}
wp.hooks.addFilter( 'editor.PostTaxonomyType', 'ta-etiquetador', postScreenTermsSelector );

const TATagsManager = compose(
	withSelect( ( select, { slug } ) => {
		const { getCurrentPost } = select( 'core/editor' );
		const { getTaxonomy } = select( 'core' );
		const taxonomy = getTaxonomy( slug );
		return {
			hasCreateAction: taxonomy
				? get(
						getCurrentPost(),
						[ '_links', 'wp:action-create-' + taxonomy.rest_base ],
						false
				  )
				: false,
			hasAssignAction: taxonomy
				? get(
						getCurrentPost(),
						[ '_links', 'wp:action-assign-' + taxonomy.rest_base ],
						false
				  )
				: false,
			taxonomy,
		};
	} ),
	withDispatch( ( dispatch ) => {
		return {
			onUpdateTerms( termsIds, restBase ) {
                console.log('TERMS UPDATE', termsIds);
				const dispatchPromise =  dispatch( 'core/editor' ).editPost( { [ restBase ]: termsIds } );
				console.log(dispatchPromise);
				return dispatchPromise;
			},
		};
	} ),
	// withFilters( 'editor.PostTaxonomyType' )
)(

	/*****************
	*	COMPONENT
	*****************/
	(props) => {
		const {
			slug: taxonomy,
			taxonomy: taxonomyData,
			terms,
			onUpdateTerms,
		} = props;

		const { termsData, setTermsData } = useRbTerms(taxonomy, terms, {
			termsQueryArgs: {
				include: terms,
				only_include: true,
				taxonomy: taxonomy,
				hide_empty: false,
			},
			// fetchArgs: {
			// 	updateOnArgsChange: false,
			// },
		});

		const onTermsChange = (selectedTerms) => {
			const postTerms = selectedTerms;
			const termsIds = postTerms ? postTerms.map( (term) => term.term_id ? term.term_id : term.id ) : [];
			setTermsData(postTerms);
			return onUpdateTerms( termsIds, taxonomyData.rest_base );
		}

		return (
			<>
				<RBTagsManager
					{...props}
					onUpdateTerms = { onTermsChange }
					terms = { termsData }
					taxonomy = { taxonomyData }
					slug = { taxonomy }
				/>
				<TAEtiquetador
					terms = { termsData }
					slug = { taxonomy }
					taxonomy = { taxonomyData }
					onUpdateTerms = { onTermsChange }
				/>
			</>
		);
	}

);
