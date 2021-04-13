import React, { useState, useEffect, useRef } from "react";
import './css/style.css';
const { apiFetch } = wp;

function useAutocomplete({
    search,
    timeout = 200,
    minLength = 3,
    requestURL,
    filterFetchArgs,
    fetchResults,
}){
    const [results, setResults] = useState([]);
    const [waitingInputEnd, setWaitingInputEnd] = useState(false);
    const [fetching, setFetching] = useState(false);
    const fetchTimeout = useRef(null);
    const lastSearchedRef = useRef('');

    useEffect( () => {
        lastSearchedRef.current = search;
        clearTimeout(fetchTimeout.current);

        if( search.length < minLength ){
            setWaitingInputEnd(false);
            setFetching(false);
            setResults([]);
            return;
        }

        setWaitingInputEnd(true);
        fetchTimeout.current = setTimeout( async () => {
            setWaitingInputEnd(false);
            setFetching(true);
            const newResults = await fetchResults({search, results});
            if(search !== lastSearchedRef.current) //If searched query changed while fetching results
                return;
            setFetching(false);
            setResults(newResults);
        }, timeout);

    }, [search]);

    return {
        results,
        waitingInputEnd,
        fetching,
        setResults,
    };
}

/**
*   Input with autocomplete functionality.
*   @param {callback} onSelect                                                  Function to excecute when an item from the autocomplete dropdown has
*                                                                               been selected. Recieves an object with `item` key
*
*   @param {callback} onSubmit                                                  Function to excecute when an the user submits the current search. Recieves
*                                                                               an object with the following keys
*       @param {string} search                                                          The submited search string
*       @param {bool} waitingInputEnd                                                   Indicates if the component is waiting for the user to stop typing to generate suggestions
*       @param {bool} fetching                                                          Indicates if a fetch is beeing perfomed
*       @param {mixed[]} results                                                        Array with current results
*
*   @param {callback} getItemLabel                                              Returns the label to show in the suggestions dropdown for the items. Recieves an object with `item` key
*   @param {callback} fetchResults                                              A function that returns a promise that resolves into the suggestions. Recieves:
*       @param {string} search                                                          The current searched string
*       @param {mixed[]} results                                                        Array with current results
*
*   @param {string} placeholder                                                 The input placeholder text
*/
const RBAutocomplete = (props) => {
    const {
        onSelect,
        onSubmit,
        getItemLabel,
        fetchResults,
        placeholder = '',
    } = props;

    const [search, setSearch] = useState('');
    const [isFocused, setIsFocused] = useState(false);
    const inputRef = useRef(null);
    const {
        results,
        waitingInputEnd,
        fetching,
        setResults,
    } = useAutocomplete({
        search,
        fetchResults,
    });
    const hasResults = results && results.length > 0;

    useEffect( () => {
        if(!inputRef.current)
            return;

        inputRef.current.addEventListener('focus', onInputFocus);
        inputRef.current.addEventListener('blur', onInputBlur);

        return () => {
            inputRef.current.removeEventListener('focus', onInputFocus);
            inputRef.current.removeEventListener('blur', onInputBlur);
        };
    }, [inputRef.current]);

    const onSubmitSearch = () => {
        if(onSubmit){
            onSubmit({
                search,
                waitingInputEnd,
                fetching,
                results,
            });
        }
    }

    const onKeyDown = (e) => {
        if (e.key === 'Enter') {
            onSubmitSearch();
        }
    }

    const onInputFocus = () => {
        setIsFocused(true);
    };

    const onInputBlur = () => {
        setTimeout( () => {
            setIsFocused(false);

        }, 100);
    };

    const onItemSelect = ({ item }) => {
        if(onSelect)
            onSelect( {item} );
        setSearch('');
    };

    const getResultsList = () => {
        const resultsItems = hasResults ? results.map( (item) => {
            const label = getItemLabel ? getItemLabel({ item }) : '';
            return (
                <div className="result-item" onClick = { () => onItemSelect({ item }) }>
                    <p className="label">{label}</p>
                </div>
            );
        }) : [];
        return <div className="results-list">{resultsItems}</div>;
    };

    return (
        <div className="rb-autocomplete">
            <input ref={inputRef} type="text" placeholder = {placeholder} className="search-input" onChange = { (e) => setSearch(e.target.value) } onKeyDown={onKeyDown}/>
            { isFocused && (waitingInputEnd || fetching || hasResults) &&
            <div className="dropdown">
                <div className="status">
                    {waitingInputEnd &&
                    <span>...</span>
                    }
                    {fetching &&
                    <span>Cargando...</span>
                    }
                </div>
                {getResultsList()}
            </div>
            }
        </div>
    );
};

export default RBAutocomplete;
