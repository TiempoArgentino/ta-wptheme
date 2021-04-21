import React, { useState, useEffect } from "react";
import {useFetchAndStore} from '../useFetchAndStore/useFetchAndStore';
const { addQueryArgs } = wp.url;
const { apiFetch } = wp;

export function fetchTerms(args){
    const { taxonomy, queryArgs } = args;
    let path = `/wp/v2/${taxonomy}`;
    path = queryArgs ? addQueryArgs(path, queryArgs) : path;
    return apiFetch({
        method: 'GET',
        path,
        parse: false
    })
    .then((data) => {
        return data.json();
    });
};

export async function fetchTerm({ name, taxonomy }){
    let path = `/wp/v2/${taxonomy}`;
    const terms = await fetchTerms({
        taxonomy,
        queryArgs: {
            search: name,
        },
    });
    let term = terms && terms.length && terms[0].name.trim().toLowerCase() == name.trim().toLowerCase() ? terms[0] : null;
    return term;
}

export function createTerm({ name, taxonomy, args = {} }){
    return apiFetch({
        method: 'POST',
        data: {
            ...args,
            name,
        },
        path: `/wp/v2/${taxonomy}`,
        parse: false
    })
    .then((data) => {
        return data.json();
    });
};

export async function fetchOrCreateTerm({ name, taxonomy }){
    let term = await fetchTerm({ name, taxonomy });
    term = term ? term : await createTerm({ name, taxonomy });
    return term;
}

export const useTerms = (props) => {
    const { taxonomy, terms, termsQueryField = 'include', onChange } = props;

    const fetchTerm = async ({ index, value: termFieldValue }) => {
        const fetchResult = await fetchTerms({
            taxonomy,
            queryArgs: {
                [termsQueryField]: termFieldValue,
            },
        });
        return fetchResult && fetchResult.length == 1 ? fetchResult[0] : null;
    }

    const {
        storedData: termsData,
        setStoredData: setTermsData,
        loading,
        error,
    } = useFetchAndStore({
        values: terms,
        fetchData: fetchTerm,
        onChange,
    });

    return {
        termsData,
        setTermsData,
        loading,
        error,
    };
}
