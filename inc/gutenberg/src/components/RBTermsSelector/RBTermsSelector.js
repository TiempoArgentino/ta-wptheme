import React, { useState, useEffect } from "react";
import RBAutocompleteList from '../../components/RBAutocompleteList/RBAutocompleteList';
import { fetchTerms, useTerms, fetchOrCreateTerm } from '../../helpers/terms/terms';
const { useSelect } = wp.data;
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

    const [fetchingCapabilities, setFetchingCapabilities] = useState(true);
    const [userCapabilities, setUserCapabilities] = useState({
        canCreate: undefined,
        canRead: undefined,
    });
    const canUser = useSelect( (select) => select('core').canUser );

    const initializeCapabilities = () => {
        if(!fetchingCapabilities)
            return true;

        const capabilities = {
            canCreate: canUser( 'create', taxonomy ),
            canRead: canUser( 'read', taxonomy ),
        };

        if( (capabilities.canCreate === undefined) || (capabilities.canRead === undefined) )
            return false;

        setUserCapabilities(capabilities);
        setFetchingCapabilities(false);
        return true;
    };

    useEffect( () => {
        // Fetch outside to trigger subscribe
        initializeCapabilities();
        const capabilityCheckUnsubscribe = wp.data.subscribe(() => {
            if(initializeCapabilities())
                capabilityCheckUnsubscribe();
        });

        return () => {
            capabilityCheckUnsubscribe();
        };
    }, []);


    const {
        termsData,
        setTermsData,
        loading: loadingTerms,
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
        userNotAllowedToRead: userNotAllowedToReadLabel = "Usted no posee los permisos necesarios para leer estos datos.",
    } = labels;

    const onChange = ({items}) => {
        setTermsData(items);
    }

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

    const loading = loadingTerms || fetchingCapabilities;

    return (
        <div className="ta-authors-selector">
            {loading &&
            <div className="loading"><Spinner/>{loadingLabel}</div>
            }
            {!loading &&
            <>
                {!userCapabilities.canRead && // User does not have the read capability for this taxonomy
                <p>{userNotAllowedToReadLabel}</p>
                }
                {userCapabilities.canRead &&
                    <RBAutocompleteList
                        items = { termsData }
                        autocompleteProps = {{
                            placeholder: inputPlaceholder,
                            fetchSuggestions: fetchSuggestions,
                            getItemLabel: ({item}) => item.name,
                        }}
                        onSubmit = {async (data) => {
                            // If user is not allowed to create, return
                            if(!userCapabilities.canCreate){
                                // alert('User is not allowed to create terms for this taxonomy');
                                return;
                            }
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
            </>
            }
        </div>
    )
};

export default RBTermsSelector;
