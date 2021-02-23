import React, { useState, useEffect, useRef } from "react";
import Autosuggest from 'react-autosuggest';

const TATagsManager = (props) => {
    const {
        terms = [],
        taxonomy,
        onTermSelected,
    } = props;

    const onNewTerm = ( { name } ) => {
        var fetchArgs = {
            method: 'POST',
            mode: 'cors', // no-cors, *cors, same-origin
            cache: 'no-cache', // *default, no-cache, reload, force-cache, only-if-cached
            credentials: 'same-origin', // include, *same-origin, omit
            headers: {
              'Content-Type': 'application/json'
              // 'Content-Type': 'application/x-www-form-urlencoded',
            },
            redirect: 'follow', // manual, *follow, error
            referrerPolicy: 'no-referrer', // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
            body: JSON.stringify({
                name: name,
            }) // body data type must match "Content-Type" header
        };

        fetch("http://localhost/wpbasetheme/wp-json/wp/v2/ta_article_tag", fetchArgs)
            .then( data => console.log(data) )
    };

    const onTermSelectedFetcher = (term) => {
        console.log('TERM SELECTED:', term);
        onTermSelected(term);
    };

    const termsButtons = () => {
        const buttons = terms ? terms.map( ({name, term_id}) => {
            return <div className="tag-button" key={term_id}>{name}</div>
        }) : '';

        if( buttons ){
            return (
                <div className="tags-buttons">
                    {buttons}
                </div>
            )
        }

        return '';
    }

    return(
        <>
            <TagsFetcher
                onTermSelected = { onTermSelectedFetcher }
                onNewTerm = { onNewTerm }
            />
            { termsButtons() }
        </>
    )
}

const TagsFetcher = (props) => {
    const {
        onTermSelected,
        onNewTerm,
        exclude,
    } = props;

    const tagsFetchURL = new URL("http://localhost/wpbasetheme/wp-json/wp/v2/ta_article_tag");
    const [inputValue, setInputValue] = useState('');
    const [suggestions, setSuggestions] = useState([]);
    const [isLoading, setIsLoading] = useState(false);
    const lastFetchedValue = useRef(null);

    useEffect(() => {
        // loadSuggestions();
    }, [inputValue])

    const loadSuggestions = (value) => {
      // Cancel the previous request (falta codigo)
      // const value = inputValue;
      setIsLoading(true);

      tagsFetchURL.search = new URLSearchParams({
          search: value,
          exclude: exclude ? exclude : '',
      }).toString();

      lastFetchedValue.current = value;

      fetch(tagsFetchURL)
        .then(response => response.json())
        .then(data => {
            if(lastFetchedValue.current == value){
                setIsLoading(false);
                setSuggestions(data);
            }
        });
    }

    const isInSuggestions = (name) => {
        return suggestions ? suggestions.find( (suggestion) => name == suggestion.name ) : false;
    }

    const onSuggestionsClearRequested = () => {
        setSuggestions([]);
    };

    const onSuggestionsFetchRequested = ({ value }) => {
        loadSuggestions(value);
    };

    const onSuggestionSelected = (event, {suggestion, suggestionValue}) => {
        if(onTermSelected){
            console.log('Tag selected:', suggestionValue);
            setInputValue('');
            onTermSelected({...suggestion, term_id: suggestion.id});
        }
    };

    const onChange = (event, { newValue, method }) => {
        setInputValue( newValue );
    };

    const onKeyDown = (event) => {
        switch (event.keyCode) {
            case 13: {
                event.preventDefault();
                if(!isInSuggestions(inputValue)){
                    if(inputValue && onNewTerm){
                        console.log('New term: ', inputValue);
                        onNewTerm({name: inputValue});
                        setInputValue('');
                    }
                }
            }
        }
    };

    const inputProps = {
        placeholder: "Type 'c'",
        value: inputValue,
        onChange,
        onKeyDown,
    };

    const getSuggestionValue = (suggestion) => {
        return suggestion.name;
    }

    const renderSuggestion = (suggestion) => {
        return (
            <span>{suggestion.name}</span>
        );
    }

     return(
        <Autosuggest
            suggestions={suggestions}
            onSuggestionsFetchRequested={onSuggestionsFetchRequested}
            onSuggestionsClearRequested={onSuggestionsClearRequested}
            getSuggestionValue={getSuggestionValue}
            renderSuggestion={renderSuggestion}
            inputProps={inputProps}
            onSuggestionSelected = { onSuggestionSelected }
            />
     )
};

export default TATagsManager;
