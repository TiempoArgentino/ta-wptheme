import React, { useState, useEffect, useRef } from "react";
import { FormTokenField } from '@wordpress/components';
import {
	escape as escapeString,
	find,
	map,
	unescape as lodashUnescapeString,
	uniqBy,
} from 'lodash';
const { addQueryArgs } = wp.url;

/**
 * Module constants
 */
const MAX_TERMS_SUGGESTIONS = 20;
const DEFAULT_QUERY = {
	per_page: MAX_TERMS_SUGGESTIONS,
	orderby: 'count',
	order: 'desc',
	_fields: 'id,name',
};

// Lodash unescape function handles &#39; but not &#039; which may be return in some API requests.
const unescapeString = ( arg ) => {
	return lodashUnescapeString( arg.replace( '&#039;', "'" ) );
};

/**
 * Returns a term object with name unescaped.
 * The unescape of the name property is done using lodash unescape function.
 *
 * @param {Object} term The term object to unescape.
 *
 * @return {Object} Term object with name property unescaped.
 */
const unescapeTerm = ( term ) => {
	return {
		...term,
		name: unescapeString( term.name ),
	};
};

/**
 * Returns an array of term objects with names unescaped.
 * The unescape of each term is performed using the unescapeTerm function.
 *
 * @param {Object[]} terms Array of term objects to unescape.
 *
 * @return {Object[]} Array of term objects unescaped.
 */
const unescapeTerms = ( terms ) => {
	return map( terms, unescapeTerm );
};

const RBTagsManager = ( props ) => {
    const {
        terms = [],
        exclude = null,
        onUpdateTerms = null,
        taxonomy,
    } = props;

    const [suggestions, setSuggestions] = useState([]);
    const [loadingSuggestions, setLoadingSuggestions] = useState(false);
    const lastFetchedValue = useRef(null);
    const addRequest = useRef(null);

    const getTermValue = ( term ) => {
        const {name, id, term_id} = term;
        return {
            ...term,
            term_id: term_id ? term_id : id,
            value: name,
        };
    }

    const getValues = () => {
        return terms ? terms.map( term => getTermValue(term).name ) : [];
    };

    const onChange = ( termNames ) => {
        console.log('termNames', termNames);
		const uniqueTermsNames = uniqBy( termNames, ( term ) => term.toLowerCase() );
		// this.setState( { selectedTerms: uniqueTerms } );
		console.log('uniqueTermsNames', uniqueTermsNames);

        // Stores the terms that are not in the props.terms array
		const newTermNames = uniqueTermsNames.filter( ( termName ) =>
			!find( terms, ( term ) => isSameTermName( term.name, termName ) )
		);
		console.log('newTermNames', newTermNames);

		const termNamesToObjects = ( names, availableTerms ) => {
			return names.map( ( termName ) =>
				find( availableTerms, ( term ) =>
					isSameTermName( term.name, termName )
				)
			);
		};

		if ( newTermNames.length === 0 ) {
            console.log(terms);
			return onUpdateTerms(
				termNamesToObjects( uniqueTermsNames, terms ),
				taxonomy.rest_base
			);
		}

        console.log('newTermNames', newTermNames);
		Promise.all( newTermNames.map( findOrCreateTerm ) ).then(
			( newTerms ) => {
                // Old terms + new terms (WP_Terms data)
				const newAvailableTerms = terms.concat( newTerms );
                console.log(newAvailableTerms, newTerms);
				// this.setState( { availableTerms: newAvailableTerms } );
				return onUpdateTerms(
					termNamesToObjects( uniqueTermsNames, newAvailableTerms ),
					taxonomy.rest_base
				);
			}
		);
	};

    const isInSuggestions = (name) => {
        return suggestions ? suggestions.find( (suggestion) => name == suggestion.name ) : false;
    }

    const loadSuggestions = (value) => {
      // Cancel the previous request (falta codigo)
      // const value = inputValue;
      setLoadingSuggestions(true);
      lastFetchedValue.current = value;

      wp.apiFetch({
          path: addQueryArgs( `/wp/v2/${ taxonomy.rest_base }`, {
              ...DEFAULT_QUERY,
              search: value,
          } ),
      })
        .then(data => {
            if(lastFetchedValue.current == value){
                const newSuggestions = data.map( term => term.name );
                setLoadingSuggestions(false);
                setSuggestions(newSuggestions);
            }
        });
    }

    const onSuggestionsFetchRequested = (value) => {
        loadSuggestions(value);
    };

    const isSameTermName = ( termA, termB ) =>
    	unescapeString( termA ).toLowerCase() ===
    	unescapeString( termB ).toLowerCase();

    const findOrCreateTerm = ( termName ) => {
		const termNameEscaped = escapeString( termName );
		// Tries to create a term or fetch it if it already exists.
		return wp.apiFetch( {
			path: `/wp/v2/${ taxonomy.rest_base }`,
			method: 'POST',
			data: { name: termNameEscaped },
		} )
			.catch( ( error ) => {
				const errorCode = error.code;
				if ( errorCode === 'term_exists' ) {
                    console.log('term_exists');
					// If the terms exist, fetch it instead of creating a new one.
					addRequest.current = wp.apiFetch( {
						path: addQueryArgs( `/wp/v2/${ taxonomy.rest_base }`, {
							...DEFAULT_QUERY,
							search: termNameEscaped,
						} ),
					} ).then( unescapeTerms );
					return addRequest.current.then( ( searchResult ) => {
						return find( searchResult, ( result ) =>  isSameTermName( result.name, termName ) );
					} );
				}
                console.log('RETURN REJECT');
				return Promise.reject( error );
			} )
			.then( finalData => {
                console.log('finalData', finalData);
                return unescapeTerm(finalData);
            });
	}

    return (
        <FormTokenField
            value={ getValues() }
            suggestions={ suggestions }
            onChange={ onChange }
            onInputChange = { onSuggestionsFetchRequested }
        />
    );
};

export default RBTagsManager;
