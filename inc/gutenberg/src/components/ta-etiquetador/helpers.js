import React, { useState, useEffect } from "react";
const { useSelect } = wp.data;

/**
*   Utilizes the etiquetador API to return suggested tags for an article.
*   @return
*   @property {string[]} result                                                 The suggested tags
*   @property {bool} fetching                                                   Indicates if the suggested tags are being fetched
*   @property {bool} error                                                      Indicates if an error ocurred while fetching the suggested tags
*/
export function useEtiquetador(props){
    const {
        text,
        amount = 20,
    } = props;

    const [result, setResult] = useState(null);
    const [fetching, setFetching] = useState(false);
    const [error, setError] = useState(false);

    useEffect( () => {
        if(!text)
            return;

        setResult(null);
        setError(false);
        setFetching(true);

        const myHeaders = new Headers();
        myHeaders.append("Content-Type", "application/json");

        const requestOptions = {
            method: 'POST',
            headers: myHeaders,
            body: JSON.stringify({
              query_string: text,
              keywords_qty: `${amount}`,
            }),
            redirect: 'follow'
        };

        fetch("https://tiempoar-supervised-learning.herokuapp.com/api/textrank", requestOptions)
            .then( response => response.json() )
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
    }, [text, amount]);

    return {
        result: result && result.keywords ? result.keywords : [],
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
