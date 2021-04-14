import React, { useState, useEffect, useRef } from "react";
import RBAutocomplete from '../../components/RBAutocomplete/RBAutocomplete';
import RBAutocompleteList from '../../components/RBAutocompleteList/RBAutocompleteList';
const { apiFetch } = wp;
import {
    remove as arrayRemove,
} from 'lodash';

function fetchTermsData({ args }){
    return apiFetch({
        method: 'POST',
        data: {
            args: args,
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
        args: {
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
        args: {
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
    } = props;
    const [termsData, setTermsData] = useState([]);
    const [doingInitialFetch, setDoingInitialFetch] = useState(true);

    useEffect( () => {
        if(terms && terms.length){
            (async () => {
                let termsData = await fetchTermsBy({ terms: terms, field: termsQueryField });
                setTermsData(termsData && termsData.length ? termsData : []);
                setDoingInitialFetch(false);
            })();
        }
        else{
            setDoingInitialFetch(false);
        };
    }, []);

    const addAuthor = ( { item } ) => {
        const mutatedTermsData = [...termsData, item];
        setTermsData(mutatedTermsData);
        updateEditorTerms({termsData: mutatedTermsData});
    }

    const removeAuthor = ( { item } ) => {
        const mutatedTermsData = [...termsData];
        arrayRemove(mutatedTermsData, termDataN => termDataN.name == item.name );
        setTermsData( mutatedTermsData );
        updateEditorTerms({termsData: mutatedTermsData});
    }

    const updateEditorTerms = (data) => {
        if(onUpdate)
            onUpdate(data);
    }

    return (
        <>
            {doingInitialFetch &&
            <div className="loading">Cargando autores del articulo</div>
            }
            {!doingInitialFetch &&
            <RBAutocompleteList
                items = { termsData }
                autocompleteProps = {{
                    placeholder: 'Buscar fotógrafo...',
                    fetchResults: autocompleteFetchTermsData,
                    getItemLabel: ({ item }) => item.name,
                }}
                onAdd = { addAuthor }
                onRemove = { removeAuthor }
            />
            }
        </>
    )
};

export default TAPhotographerSelector;
