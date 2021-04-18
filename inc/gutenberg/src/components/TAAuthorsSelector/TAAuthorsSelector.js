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
            orderby: 'include',
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
        max = 0,
        sortable = false,
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

    const updateEditorTerms = ({items}) => {
        setAuthors( items );
        if(onUpdate)
            onUpdate({
                authors: items,
            });
    }

    const renderAuthorItem = ({item, removeItem}) => {
        return <TAArticleAuthorMetaBlock author = {item} onRemove = { removeItem } />;
    };

    return (
        <div className="ta-authors-selector">
            {doingInitialFetch &&
            <div className="loading">Cargando autores del articulo</div>
            }
            {!doingInitialFetch &&
            <RBAutocompleteList
                items = { authors }
                autocompleteProps = {{
                    placeholder: 'Buscar autor...',
                    fetchSuggestions: autocompleteFetchAuthors,
                    getItemLabel: ({ item }) => item.name,
                }}
                labels = {{
                    maxReached: 'Se alcanzó la máxima cantidad de autores.',
                }}
                itemRender = { renderAuthorItem }
                onChange = { updateEditorTerms }
                getItemKey = { ({item}) => item.term.term_id }
                sortable = {sortable}
                max = {max}
            />
            }
        </div>
    )
};
export default TAAuthorsSelector;
