import React, { useState, useEffect } from "react";
import {useFetchAndStore} from '../useFetchAndStore/useFetchAndStore';
const { addQueryArgs } = wp.url;
const { apiFetch } = wp;

export function fetchTerms(args){
    const { taxonomy, queryArgs } = args;
    let path = `/wp/v2/${taxonomy}`;
    path = queryArgs ? addQueryArgs(path, queryArgs) : path;
    console.log('Searching', path);
    return apiFetch({
        method: 'GET',
        path,
        parse: false
    });
};

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
};

export async function fetchOrCreateTerm({ name, taxonomy }){
    let result = {
        term: null,
        error: false,
        isNew: true,
    };

    let createTermResult = await createTerm({ name, taxonomy })
    // TERM CREATION SUCCESS
    .then( async (response) => {
        const data = await response.json();
        result.term = data;
    })
    // TERM CREATION FAIL - TERM EXIST OR ERROR
    .catch( async (response) => {
        response = await response.json();

        // ERROR
        if( response.code != "term_exists" ){
            result.error = data;
            return response;
        }

        // Term exists - Fetch
        const data = response.data;
        result.isNew = false;
        let fetchTermResult = await fetchTerms({
            taxonomy,
            queryArgs: {
                include: data.term_id,
            },
         })
         // EXISTING TERM FETCH SUCCESS
        .then( async (response) => {
            const data = await response.json();
            result.term = data && data.length == 1 ? data[0] : null;
        } )
        // FETCH EXISTING TERM ERROR
        .catch( async (response) => {
            result.error = await response.json();
        } );

        return response;
    } );

    return result;
}

export const useTerms = (props) => {
    const { taxonomy, terms, termsQueryField = 'include', onChange } = props;

    const fetchTerm = async ({ index, value: termFieldValue }) => {
        const fetchResult = await fetchTerms({
            taxonomy,
            queryArgs: {
                [termsQueryField]: termFieldValue,
            },
        })
        .then( data => data.json() );
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
