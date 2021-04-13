import React, { useState, useEffect, useRef } from "react";
import RBAutocomplete from '../RBAutocomplete/RBAutocomplete';
import './css/style.css';

/**
*   @param {mixed} items                                                        The items array
*   @param {callback} onRemove                                                  Function to excecute when an item gets removed. Recieves an object with key `item`
*   @param {callback} onAdd                                                     Function to excecute when an item its added. Recieves an object with key `item`
*   @param {callback} itemRender                                                Function that renders an item in the items list. Recieves:
*       @param {mixed} item                                                         The item to render
*       @param {callback} removeItem                                                A function used to remove the item from the list
*   @param {object} autocompleteProps                                           See RBAutocomplete
*/
const RBAutocompleteList = (props) => {
    const {
        items,
        onRemove,
        onAdd,
        itemRender,
        autocompleteProps = {},
    } = props;

    const {
        fetchResults,
    } = autocompleteProps;

    const hasItems = items && items.length;
    const getItemsList = () => {
        const itemsItems = hasItems ? items.map( (item) => {
            const {name} = item;
            const remove = () => {
                removeItem({item});
            };
            return itemRender ? itemRender({
                item,
                removeItem: remove,
            }) : <div className="item" onClick = { remove }>{name}</div>;
        }) : [];
        return <div className="items-list">{itemsItems}</div>;
    };

    const addItem = ( { item } ) => {
        if(onAdd)
            onAdd({ item });
    }

    const removeItem = ( { item } ) => {
        if(onRemove)
            onRemove({ item });
    }

    const doFetchResults = (data) => {
        return fetchResults ? fetchResults({...data, items: items}) : [];
    }

    return (
        <div className="rb-autocomplete-list">
            <RBAutocomplete
                {...autocompleteProps}
                fetchResults = { doFetchResults }
                onSelect = { addItem }
            />
            {getItemsList()}
        </div>
    )
};


export default RBAutocompleteList;
