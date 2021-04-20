import React, { useState, useEffect } from "react";
import {useFetchAndStore} from '../useFetchAndStore/useFetchAndStore';
const { apiFetch } = wp;

export function fetchAuthors({ args }){
    return apiFetch({
        method: 'POST',
        data: {
            args: args,
        },
        path: "/ta/v1/authors",
        parse: false
    })
    .then((data) => {
        return data.json();
    });
};

export function fetchAuthorsBy({ terms, field = 'include' }){
    return fetchAuthors({
        args: {
            orderby: 'include',
            order: 'ASC',
            hide_empty: false,
            [field]: terms && terms.length ? terms : [],
        },
    });
}

export const useTAAuthors = (props) => {
    const { terms, termsQueryField = 'include' } = props;
    const termFieldName = termsQueryField == 'include' ? 'term_id' : termsQueryField;

    const fetchAuthor = async ({ index, value: termFieldValue }) => {
        const fetchResult = await fetchAuthorsBy({ terms: [termFieldValue], field: termsQueryField });
        return fetchResult && fetchResult.length == 1 ? fetchResult[0] : null;
    }

    const {
        storedData: authorsData,
        setStoredData: setAuthors,
        loading,
        error,
    } = useFetchAndStore({
        values: terms,
        fetchData: fetchAuthor,
    });

    return {
        authors: authorsData,
        setAuthors,
        loading,
        error,
    };
}
