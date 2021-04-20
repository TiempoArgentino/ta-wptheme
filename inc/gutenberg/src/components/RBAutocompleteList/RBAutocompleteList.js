import React, { useRef } from "react";
import RBAutocomplete from '../RBAutocomplete/RBAutocomplete';
import { ReactSortable } from "react-sortablejs";
const { Dashicon } = wp.components;
import './css/style.css';


/**
*   @param {mixed} items                                                        The items array
*   @param {callback} onChange                                                  Function to excecute when the list gets changed (items removed/added/sorted).
*                                                                               Recieves an object with key `item`
*   @param {callback} itemRender                                                Function that renders an item in the items list. Recieves:
*       @param {mixed} item                                                         The item to render
*       @param {callback} removeItem                                                A function used to remove the item from the list
*   @param {object} autocompleteProps                                           See RBAutocomplete
*/
const RBAutocompleteList = (props) => {
    const {
        items,
        onChange,
        itemRender,
        filterNewItem,
        getItemLabel,
        autocompleteProps = {},
        getItemKey,
        sortable = false,
        handle = null,
        max = 0,
        labels = {},
        disabled = false,
        onSubmit,
    } = props;

    const {
        fetchSuggestions,
    } = autocompleteProps;

    const {
        maxReached: maxReachedLabel = 'Max amount reached!',
    } = labels;
    const listRef = useRef();
    const hasItems = items && items.length;
    const hasMaxLimit = max > 0;
    const hasMaxItems = hasMaxLimit && items.length >= max;

    const getItemsList = () => {
        let list = null;
        let itemsComponents = [];
        if(hasItems){
            let amountToShow = hasMaxItems ? max : items.length;

            for(let index = 0; index < amountToShow; index++){
                const item = items[index];
                const label = getItemLabel ? getItemLabel({item}) : '';
                const remove = () => removeItem({ item, index, });
                const key = getItemKey({item});
                const itemComponent = itemRender ? itemRender({
                    item,
                    key,
                    index,
                    removeItem: remove,
                }) :
                    <div className="item" key={key}>
                        <div className="title">{label}</div>
                        <div className="rmv-btn"><Dashicon className="icon" icon="no-alt" onClick = { remove }/></div>
                    </div>;
                itemsComponents.push(itemComponent);
            }
        }

        if(sortable && itemsComponents.length > 1){
            list = (
                <ReactSortable className="items-list" list={items} setList={ sortItems } handle = {handle}>
                    {itemsComponents}
                </ReactSortable>
            );
        }
        else {
            list = <div className="items-list">{itemsComponents}</div>;
        }

        return list;
    };

    const doOnChange = ({ action, data }) => {
        if(onChange){
            let newItems = [];
            let needsUpdate = true;
            switch (action){
                case 'add':
                    if(max == 1 || !hasMaxItems){
                        const newItem = filterNewItem ? filterNewItem({ item: data.item }) : data.item;
                        if(max == 1) //Swap item
                            newItems = [newItem];
                        else
                            newItems = [...items, newItem ];
                    }
                    else if (hasMaxItems){ // No change
                        needsUpdate = false;
                        break;
                    }
                    break;
                case 'remove':
                    newItems = [...items];
                    newItems.splice(data.index, 1);
                    break;
                case 'sort':
                    newItems = data;
                    break;
                case 'default':
                    newItems = data.items;
                    break;
            }

            if(needsUpdate){
                onChange({
                    items: newItems,
                    action,
                    data,
                });
            }
        }
    };

    const addItem = ( data ) => doOnChange({ action: 'add', data });

    const removeItem = ( data ) => doOnChange({ action: 'remove', data });

    const sortItems = ( data ) => doOnChange({ action: 'sort', data });

    const doFetchSuggestions = (data) => {
        return fetchSuggestions ? fetchSuggestions({...data, items: items}) : [];
    }

    const onSubmitInput = (data) => {
        if(onSubmit)
            onSubmit({...data, addItem});
    };

    return (
        <div className="rb-autocomplete-list" ref={listRef}>
            <RBAutocomplete
                {...autocompleteProps}
                onSubmit = {onSubmitInput}
                fetchSuggestions = { doFetchSuggestions }
                onSelect = { addItem }
                disabled = { disabled || (hasMaxItems && max != 1) }
            />
            { hasMaxItems && max != 1 && <p className="max-reached-label">{maxReachedLabel}</p> }
            {getItemsList()}
        </div>
    )
};


export default RBAutocompleteList;
