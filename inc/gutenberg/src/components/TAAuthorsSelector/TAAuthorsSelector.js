import React, { useState, useEffect, useRef } from "react";
import RBAutocomplete from '../../components/RBAutocomplete/RBAutocomplete';
import RBAutocompleteList from '../../components/RBAutocompleteList/RBAutocompleteList';
import TAArticleAuthorMetaBlock from '../../components/TAArticleAuthorMetaBlock/TAArticleAuthorMetaBlock';
const { apiFetch } = wp;
import {
    remove as arrayRemove,
} from 'lodash';

function fetchAuthors({ args }){
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

function autocompleteFetchAuthors({search, items}){
    return fetchAuthors({
        args: {
            name__like: search,
            orderby: 'name',
            order: 'ASC',
            hide_empty: false,
            exclude: items ? items.map(author => author.term.term_id) : [],
        },
    });
}

function fetchAuthorsById({ authorsIds }){
    return fetchAuthors({
        args: {
            orderby: 'name',
            order: 'ASC',
            hide_empty: false,
            include: authorsIds && authorsIds.length ? authorsIds : [],
        },
    });
}

const TAAuthorsSelector = (props) => {
    const {
        authorsIds,
        onUpdate,
    } = props;
    const [authors, setAuthors] = useState([]);
    const [doingInitialFetch, setDoingInitialFetch] = useState(true);

    useEffect( () => {
        if(authorsIds && authorsIds.length){
            (async () => {
                let authors = await fetchAuthorsById({ authorsIds: authorsIds});
                setAuthors(authors && authors.length ? authors : []);
                console.log('FETCH RES authors', authors);
                setDoingInitialFetch(false);
            })();
        }
        else{
            setDoingInitialFetch(false);
        };        
    }, []);

    const addAuthor = ( { item } ) => {
        const mutatedAuthors = [...authors, item];
        setAuthors(mutatedAuthors);
        updateEditorTerms({authors: mutatedAuthors});
    }

    const removeAuthor = ( { item } ) => {
        const mutatedAuthors = [...authors];
        arrayRemove(mutatedAuthors, authorN => authorN.name == item.name );
        setAuthors( mutatedAuthors );
        updateEditorTerms({authors: mutatedAuthors});
    }

    const updateEditorTerms = (data) => {
        if(onUpdate)
            onUpdate(data);
    }

    const renderAuthorItem = ({item, removeItem}) => {
        return <TAArticleAuthorMetaBlock author = {item} onRemove = { removeItem } />;
    };

    return (
        <>
            {doingInitialFetch &&
            <div className="loading">Cargando autores del articulo</div>
            }
            {!doingInitialFetch &&
            <RBAutocompleteList
                items = { authors }
                autocompleteProps = {{
                    placeholder: 'Buscar autor...',
                    fetchResults: autocompleteFetchAuthors,
                    getItemLabel: ({ item }) => item.name,
                }}
                onAdd = { addAuthor }
                onRemove = { removeAuthor }
                itemRender = { renderAuthorItem }
            />
            }
        </>
    )
};
export default TAAuthorsSelector;
