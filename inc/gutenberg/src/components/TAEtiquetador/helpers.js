import React, { useState, useEffect } from "react";
const { useSelect, useDispatch, registerGenericStore } = wp.data;
const {apiFetch} = wp;

/**
*   Utilizes the etiquetador API to return suggested tags for an article.
*   @return
*   @property {string[]} tags                                                   The suggested tags
*   @property {string[]} analizedText                                           The latest analized text
*   @property {function} updateTags                                             Function that recieves text an amount, and sets the result state.
*   @property {bool} fetching                                                   Indicates if the suggested tags are being fetched
*   @property {bool} error                                                      Indicates if an error ocurred while fetching the suggested tags
*/
export function useEtiquetador(props){
    const etiquetadorStates = useSelect( ( select ) => {
       return select('ta-etiquetador');
    } );
    const result = etiquetadorStates.getResult();
    const {setResult} = useDispatch('ta-etiquetador');
    const {
        keywords: tags = [],
        text: analizedText = '',
    } = result ? result : {};
    const [fetching, setFetching] = useState(false);
    const [error, setError] = useState(false);

    const updateTags = ({
        text, amount
    }) => {
        if(!text)
            return;

        setResult(null);
        setError(false);
        setFetching(true);

        const myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        const requestOptions = {
            path: `/ta/v1/etiquetador`,
            // parse: false,
            method: 'POST',
            headers: myHeaders,
            data: {
              query_string: text,
              keywords_qty: `${amount}`,
            },
            redirect: 'follow'
        };

        apiFetch( requestOptions )
            // .then( response => response.json() )
            .catch( error => {
                console.log('ERROR', error);
                setError(error);
                setFetching(false);
                throw error;
            })
            .then( finalData => {
                console.log('finalData', finalData);
                setResult(finalData);
                setFetching(false);
                return finalData;
            });
    };

    return {
        tags,
        analizedText,
        updateTags,
        fetching,
        error,
    };
}

/**
*   @return {string} The current text content of the current post. The post title is
*   prepended to the main content.
*   It updates with any change in title or content.
*/
export const useArticleText = () => {
    const [articleText, setArticleText] = useState('');

    const postContent = useSelect( ( select ) => {
       return select('core/editor').getEditedPostContent();
    } );

    const postTitle = useSelect( ( select ) => {
       return select('core/editor').getEditedPostAttribute('title');
    } );

    const richText = wp.richText.create({
        html: `${postTitle}
        ${postContent}`,
    })

    if(richText.text !== articleText)
        setArticleText(richText.text);

    return articleText;
};

registerGenericStore( 'ta-etiquetador', (() => {
    let storeChanged = () => {};
    let result = null;

    const selectors = {
        getResult: () => {
            return result;
        },
    };

    const actions = {
        setResult: (newResult) => {
            result = newResult;
            storeChanged();
        },
    };

    return {
        getSelectors: () => {
            return selectors;
        },
        getActions: () => {
            return actions;
        },
        subscribe: ( listener ) => {
            storeChanged = listener;
        },
    };
})() );
