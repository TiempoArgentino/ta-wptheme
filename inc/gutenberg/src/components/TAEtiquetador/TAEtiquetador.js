import React, { useState, useEffect, useRef } from "react";
import {
    escape as escapeString,
	unescape as lodashUnescapeString,
    get,
    map,
    uniqBy,
    find,
    remove,
} from 'lodash';
import {useEtiquetador, useArticleText} from './helpers';
import style from './style.css';
const { useSelect } = wp.data;
const { addQueryArgs } = wp.url;
const { Button, Spinner } = wp.components;

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

const TAEtiquetador = (props) => {
    const {
        terms,
        taxonomy,
        onUpdateTerms,
    } = props;

    // Etiquetador API
    const {
        tags: etiquetadorTags,
        analizedText,
        updateTags,
        fetching: etiquetadorFetching,
        error: etiquetadorError,
    } = useEtiquetador();

    const articleCurrentText = useArticleText();
    const [ fetchingTags, setFetchingTags ] = useState(false);
    const [ loading, setLoading ] = useState(false);
    const [ selectedTermsNames, setSelectedTermsNames ] = useState([]);
    const [ requestedTermsNames, setRequestedTermsNames ] = useState([]);
    const [ tagsOnQueue, setTagsOnQueue ] = useState([]);
    const tagsFetchTimeout = useRef(null);
    const fetchWaitTimeout = useRef(null);
    const textChanged = articleCurrentText != analizedText;
    const initRequest = useRef(null);
    const addRequest = useRef(null);
    const termNames = [];
    const termsIds = [];


    // Wait for the user to stop selecting tags
    useEffect( () => {
        clearTimeout(tagsFetchTimeout.current);
        if(tagsOnQueue.length){
            if(!fetchingTags){
                tagsFetchTimeout.current = setTimeout( () => {
                    onChange(tagsOnQueue);
                    setTagsOnQueue([]);
                }, 500);
            }
        }
    }, [tagsOnQueue, fetchingTags]);

    // Populate termNames and termsIds arrays
    if(terms){
        terms.forEach((term, i) => {
            termNames.push(term.name);
            termsIds.push(term.id ? term.id : term.term_id);
        });
    }

    /**
    *   Cheks if the tags exists, and retrieves or creates them, dispatching the result updating the post.
    */
    const onChange = ( newTermsNames ) => {
        const updatedTermNames = termNames.concat(newTermsNames);
		const uniqueTermsNames = uniqBy( updatedTermNames, ( term ) => term.toLowerCase() );
        setSelectedTermsNames(uniqueTermsNames);

        // New terms aren't in availableTerms
		const newTermNames = uniqueTermsNames.filter( ( termName ) =>
			! find( terms, ( term ) => isSameTermName( term.name, termName ) )
		);

		const termNamesToObjects = ( names, availableTerms ) => {
			return names.map( ( termName ) =>
				find( availableTerms, ( term ) =>
					isSameTermName( term.name, termName )
				)
			);
		};

		if ( newTermNames.length === 0 ) {
			return onUpdateTerms(
				termNamesToObjects( uniqueTermsNames, terms ),
				taxonomy.rest_base
			);
		}

        setFetchingTags(true);
        setRequestedTermsNames([...requestedTermsNames, ...newTermNames]);
        Promise.all( newTermNames.map( findOrCreateTerm ) ).then(
			( newTerms ) => {
                // Old terms + new terms (WP_Terms data)
				const newAvailableTerms = terms.concat( newTerms );
				// this.setState( { availableTerms: newAvailableTerms } );
                const requestedTermsNamesCopy = [...requestedTermsNames];
                newTermNames.forEach((termName, i) => {
                    remove(requestedTermsNamesCopy, (storedTermName) => storedTermName == termName);
                });
                setRequestedTermsNames([...requestedTermsNamesCopy]);
				return onUpdateTerms(
					termNamesToObjects( uniqueTermsNames, newAvailableTerms ),
					taxonomy.rest_base
				).then( () => {
                    setFetchingTags(false);
                });
			}
		);
	}

    /**
    *   Returns tag data. If it doesn't exists, it creates it.
    */
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
				return Promise.reject( error );
			} )
			.then( finalData => {
                return unescapeTerm(finalData);
            });
	}

    const generateTags = () => {
        if(!etiquetadorFetching && textChanged){
            updateTags({
                text: articleCurrentText,
                amount: 20,
            })
        }
    }

    const enqueueTag = (tagName) => setTagsOnQueue([...tagsOnQueue, tagName]);

    const isSameTermName = ( termA, termB ) => unescapeString( termA ).toLowerCase() === unescapeString( termB ).toLowerCase();

    const isTermBeingFetched = (termName) => find( requestedTermsNames, ( term ) => isSameTermName( term, termName ) );

    const isTermInQueue = (termName) => find( tagsOnQueue, ( term ) => isSameTermName( term, termName ) );

    const isTagBeingLoaded = (tagName) => isTermInQueue(tagName) || isTermBeingFetched(tagName);

    const newTagsNames = etiquetadorTags ? etiquetadorTags.filter( ( termName ) => !find( terms, ( term ) => isSameTermName( term.name, termName ) ) ) : null;

    const getTagsButtons = ({onlyDisabled = false} = {}) => {
        const tagsButtons = newTagsNames ? newTagsNames.filter( tagName => !isTagBeingLoaded(tagName) ).map( tagName => {
            return (
                <Button
                    disabled = { false }
                    isSecondary
                    className="tag-btn"
                    key={ unescapeString(tagName) }
                    onClick={ () => enqueueTag(tagName)}
                >{tagName}</Button>
            )
        }) : '';

        return tagsButtons && tagsButtons.length ? <div className="tags-container">{tagsButtons}</div> : ''
    };

    const getTagsLoadingButtons = () => {
        const tagsButtons = newTagsNames ? newTagsNames.filter( tagName => isTagBeingLoaded(tagName) ).map( tagName => {
            return (
                <Button
                    disabled = { true }
                    isSecondary
                    className="tag-btn"
                    key={ unescapeString(tagName) }
                >{tagName}</Button>
            )
        }) : '';

        return tagsButtons && tagsButtons.length ? (
            <div>
                <p className="">Agregando los siguientes tags:</p>
                <div className="tags-container tags-fetching">{tagsButtons}</div>
            </div>
        ) : ''  ;
    };

    return (
        <div className="ta-etiquetador">
            <div className="header">
                <p className="title">Tags recomendados</p>
            </div>
            { !newTagsNames.length && !etiquetadorFetching &&
            <div className="no-tags">
                <p>No hay tags recomendados. Intente modificando el contenido
                del articulo y volviendo a hacer click en "GENERAR TAGS"</p>
            </div>
            }
            { getTagsButtons() }
            { getTagsLoadingButtons() }
            { etiquetadorFetching &&
            <div className="loading-spinner">
                <Spinner/>
            </div>
            }
            <Button
                disabled = { !textChanged }
                className="generator-btn btn"
                onClick = { generateTags }
                isSecondary
            >{ etiquetadorFetching ? 'GENERANDO' : 'GENERAR TAGS'}</Button>
        </div>
    );
};

export default TAEtiquetador;


// const { termsData, setTermsData } = useRbTerms(taxonomy, terms, {
//     termsQueryArgs: {
//         include: terms,
//         only_include: true,
//         taxonomy: taxonomy,
//         include: terms.join( ',' ),
//         per_page: -1,
//     },
//     // fetchArgs: suplementsFetchArgs,
// });

// const onChange = ( termNames ) => {
//     console.log('termNames', termNames);
// 	const uniqueTermsNames = uniqBy( termNames, ( term ) => term.toLowerCase() );
// 	// this.setState( { selectedTerms: uniqueTerms } );
//
//     // Stores the terms that are not in the props.terms array
// 	const newTermNames = uniqueTermsNames.filter( ( termName ) =>
// 		!find( terms, ( term ) => isSameTermName( term.name, termName ) )
// 	);
//
// 	const termNamesToObjects = ( names, availableTerms ) => {
// 		return names.map( ( termName ) =>
// 			find( availableTerms, ( term ) =>
// 				isSameTermName( term.name, termName )
// 			)
// 		);
// 	};
//
// 	if ( newTermNames.length === 0 ) {
//         console.log(terms);
// 		return onUpdateTerms(
// 			termNamesToObjects( uniqueTermsNames, terms ),
// 			taxonomy.rest_base
// 		);
// 	}
//
//     console.log('newTermNames', newTermNames);
// 	Promise.all( newTermNames.map( findOrCreateTerm ) ).then(
// 		( newTerms ) => {
//             // Old terms + new terms (WP_Terms data)
// 			const newAvailableTerms = terms.concat( newTerms );
//             console.log(newAvailableTerms, newTerms);
// 			// this.setState( { availableTerms: newAvailableTerms } );
// 			return onUpdateTerms(
// 				termNamesToObjects( uniqueTermsNames, newAvailableTerms ),
// 				taxonomy.rest_base
// 			);
// 		}
// 	);
// };
