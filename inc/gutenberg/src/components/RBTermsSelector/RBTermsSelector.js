import React, { useState, useEffect } from "react";
import RBAutocompleteList from '../../components/RBAutocompleteList/RBAutocompleteList';
import { fetchTerms, useTerms, fetchOrCreateTerm } from '../../helpers/terms/terms';
const { useDispatch } = wp.data;
const { apiFetch } = wp;
const { Spinner } = wp.components;

function autocompleteFetchTerms({taxonomy, search, termsData}){
    return fetchTerms({
        taxonomy: taxonomy,
        queryArgs: {
            search: search,
            orderby: 'name',
            order: 'asc',
            hide_empty: false,
            exclude: termsData ? termsData.map(term => term.data.id) : [],
        },
    }).then( response => response.json() );
}

const RBTermsSelector = (props) => {
    const {
        taxonomy,
        terms,
        termsQueryField = 'include',
        renderItem,
        onUpdate,
        onSubmit,
        max = 0,
        sortable = false,
        disabled = false,
        labels = {},
    } = props;

    const {
        termsData,
        setTermsData,
        loading,
    } = useTerms({ taxonomy, terms, termsQueryField,
        onChange: (data) => {
            const {dataBeingFetched} = data;
            if(!dataBeingFetched && onUpdate){
                onUpdate({
                    ...data,
                    termsData: termsData,
                });
            }
        },
    });
    const termFieldName = termsQueryField == 'include' ? 'id' : termsQueryField;

    const {
        inputPlaceholder = "Buscar...",
        loading: loadingLabel = "Cargando...",
        maxReached: maxReachedLabel = "No se pueden agregar mas terms",
    } = labels;

    const onChange = ({items}) => {
        setTermsData(items);
    }

    useEffect( () => {

    }, [termsData]);

    const fetchSuggestions = (data) => {
        return autocompleteFetchTerms({ ...data, taxonomy, termsData });
    }

    const getItemLabel = ({item}) => {
        if(item.loading)
            return <Spinner/>

        if(item.data && item.data.name)
            return item.data.name;

        return null;
    }

    return (
        <div className="ta-authors-selector">
            {loading &&
            <div className="loading"><Spinner/>{loadingLabel}</div>
            }
            {!loading &&
            <RBAutocompleteList
                items = { termsData }
                autocompleteProps = {{
                    placeholder: inputPlaceholder,
                    fetchSuggestions: fetchSuggestions,
                    getItemLabel: ({item}) => item.name,
                    onSubmit: async (data) => {
                        // const { search, addItem } = data;
                        // const comparableSearch = search.trim().toLowerCase();
                        // if( termsData.find( term => term.data.name.toLowerCase() == comparableSearch ) )
                        //     return;
                        // addItem
                        // setTermsData([...termsData, {
                        //     data: {
                        //         name: search,
                        //     },
                        //     loading: true,
                        //     originalValue: search,
                        //     fetchPromise: async () => {
                        //         const term = await fetchOrCreateTerm({ name: search, taxonomy });
                        //         // if( term && !termsData.find( item => item.data.id == term.id ) )
                        //         //     onChange( { items: [...terms, term] } );
                        //         return term;
                        //     },
                        //     fetchFilter: (storedData) => {
                        //         return {
                        //             ...storedData,
                        //             originalValue: storedData.data[termFieldName],
                        //         };
                        //     },
                        // }]);
                    },
                }}
                onSubmit = {async (data) => {
                    const { search, addItem } = data;
                    const comparableSearch = search.trim().toLowerCase();
                    if( termsData.find( term => term.data.name.toLowerCase() == comparableSearch ) )
                        return;
                    addItem({
                        item: {
                            data: {
                                name: search,
                            },
                            loading: true,
                            originalValue: search,
                            fetchPromise: async () => {
                                const { term } = await fetchOrCreateTerm({ name: search, taxonomy });
                                // if( term && !termsData.find( item => item.data.id == term.id ) )
                                //     onChange( { items: [...terms, term] } );
                                return term;
                            },
                            fetchFilter: (storedData) => {
                                return {
                                    ...storedData,
                                    originalValue: storedData.data[termFieldName],
                                };
                            },
                        },
                    });
                }}
                labels = {{
                    maxReached: maxReachedLabel,
                }}
                itemRender = { renderItem }
                onChange = { onChange }
                getItemKey = { ({item}) => item[termFieldName] }
                filterNewItem = { ({item}) => {
                    return item.data ? item : {
                        data: item,
                        loading: false,
                        originalValue:  item[termFieldName],
                    }
                }}
                getItemLabel = { getItemLabel }
                sortable = {sortable}
                max = {max}
                disabled = {disabled}
            />
            }
        </div>
    )
};

export default RBTermsSelector;
