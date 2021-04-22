import React, { useState, useEffect, useRef } from "react";
import TAArticlePreview from '../TAArticlePreview/TAArticlePreview';
import useArticleRowData from '../../helpers/useArticleRowData/useArticleRowData';
const { Spinner, RangeControl, ToggleControl } = wp.components;
import './css/editor.css';

function getCellsAmount(rowConfig){
    return rowConfig.cells_amount ? rowConfig.cells_amount : 4;
}

const Controls = ( { row, index, onUpdate } ) => {
    const updateRow = (attribute, value) => {
        if(!onUpdate)
            return;

        const rowConfig = {...row};
        rowConfig[attribute] = value;

        onUpdate({
            row: rowConfig,
            index,
        });
    };

    return (
        <>
            <ToggleControl
                label = "Rellenar espacio vacio"
                checked = { row.fill }
                onChange={ (value) => updateRow('fill', value) }
            />
            <RangeControl
                label = "Cantidad"
                value = { row.cells_amount ? row.cells_amount : 4 }
                min = {1}
                max = {4}
                onChange={ (amount) => updateRow('cells_amount', amount) }
            />
            { false &&
            <RangeControl
                label="Maximo de celdas por fila"
                value={ attributes.cells_per_row }
                onChange={(amount) => setAttribute('cells_per_row', amount)}
                min={ 1 }
                max={ 4 }
            />
            }
        </>
    );
}


const TAArticlesCommonRow = (props = {}) => {
    const {
        articles,
        offset,
        cells,
        isSelected,
        cells_per_row = 4,
        fill = false,
    } = props;

    const cellsAmount = getCellsAmount(props);

    const {
        hasArticles,
        getCellData,
        className,
    } = useArticleRowData(props);

    const getCells = () => {
        const cells = [];
        const leftovers = fill ? cellsAmount % cells_per_row : 0;
        const flexFill = fill && leftovers;

        for( let i = 0; i < cellsAmount; i++){
            const cellData = getCellData(i);
            const cellWidth = leftovers && i < leftovers ? 100 / leftovers : 100 / cells_per_row;
            const cellSize = cellWidth >= 50 ? 'large' : 'common';

            const style = {
                flex: `${cellWidth}%`,
                maxWidth: `${cellWidth}%`,
            };

            cells.push(
                <div className={ `cell ${cellSize} ${cellData.className}`} style = {style}>
                    { cellData.article &&
                        <TAArticlePreview
                            article = { cellData.article }
                            size = {cellSize}
                            orientation = "vertical"
                        />
                    }
                </div>
            );
        }

        return cells;
    };

    return (
        <div className={`articles-list common ${className}`}>
            {getCells()}
        </div>
    );

};

const data = {
    component: TAArticlesCommonRow,
    getCellsAmount,
    Controls: Controls,
    defaultConfig: {
        cells_amount: 4,
        fill: false,
    },
};

export default data;
