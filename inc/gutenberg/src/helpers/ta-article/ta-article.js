import React, { useState, useEffect, useRef } from "react";
const { apiFetch } = wp;

export function useTAArticles(props = {}){
    const {
        queryArgs = null,
        onThen = null,
    } = props;

    const [articles, setArticles] = useState(null);
    const [fetching, setFetching] = useState(false);
    const [error, setError] = useState(null);

    useEffect(() => {
        if(!queryArgs)
            return;

        apiFetch({
            data: {
                queryArgs,
            },
            method: 'POST',
            path: '/ta/v1/articles',
            parse: false
        })
        .then((response) => {
            return response.json();
        })
        .then((responseData) => {
            //console.log(state);
            setArticles(responseData);
            if(props.onThen)
                props.onThen({response, responseData});
        });

    }, [queryArgs]);

    return {
        articles,
        fetching,
        error,
    };

}
