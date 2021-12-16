import React, { useState, useEffect, useRef } from "react";
import RBAutocomplete from '../../components/RBAutocomplete/RBAutocomplete';
import RBAutocompleteList from '../../components/RBAutocompleteList/RBAutocompleteList';
const { apiFetch } = wp;
import {
    remove as arrayRemove,
} from 'lodash';

function fetchTermsData({ queryArgs, options: [] }){
    return apiFetch({
        method: 'POST',
        data: {
            queryArgs,
            options,
        },
        path: "/ta/v1/photographers",
        parse: false
    })
    .then((data) => {
        return data.json();
    });
};

function autocompleteFetchTermsData({search, items}){
    return fetchTermsData({
        queryArgs: {
            name__like: search,
            orderby: 'name',
            order: 'ASC',
            hide_empty: false,
            exclude: items ? items.map(termData => termData.term.term_id) : [],
        },
    });
}

function fetchTermsBy({ terms, field = 'include' }){
    return fetchTermsData({
        queryArgs: {
            orderby: 'name',
            order: 'ASC',
            hide_empty: false,
            [field]: terms && terms.length ? terms : [],
        },
    });
}

const TAPhotographerSelector = (props) => {
    const {
        terms,
        termsQueryField = 'include',
        onUpdate,
        max = 0,
        sortable = false,
        disabled = false,
    } = props;

    const onChange = ({items}) => {
        if(onUpdate)
            onUpdate({
                photographers: items,
            });
    }

    return (
        <RBTermsSelector
            taxonomy = "ta_photographer"
            terms = {terms}
            termsQueryField = {termsQueryField}
            onUpdate = {onChange}
            renderItem = { renderAuthorItem }
            autocompleteProps = {{
                placeholder: 'Buscar fotógrafo...',
                fetchSuggestions: autocompleteFetchTermsData,
                getItemLabel: ({ item }) => item.name,
            }}
            labels = {{
                maxReached: 'Se alcanzó la máxima cantidad de fotógrafos.',
            }}
        />
    )
};

export default TAPhotographerSelector;
