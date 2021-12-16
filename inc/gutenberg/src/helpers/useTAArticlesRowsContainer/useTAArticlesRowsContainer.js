import React, { useState, useEffect, useRef } from "react";
import sliderRow from '../../components/TAArticlesSliderRow/TAArticlesSliderRow';
import miscelaneaRow from '../../components/TAArticlesMiscelaneaRow/TAArticlesMiscelaneaRow';
import commonRow, { getRowCellsAmount as commonRowCellsAmount } from '../../components/TAArticlesCommonRow/TAArticlesCommonRow';
import './css/editor.css';
import balancerImage from './balancer.png';
const { Spinner, Icon, SelectControl, ToggleControl, Tooltip } = wp.components;

const useTAArticlesRowsContainer = (props = {}) => {
    const {
        rows,
        onMoveRow,
        onClickRow,
        onRemoveRow,
        selectedRowIndex,
        showEmpty = true,
        showControls = true,
        updateRow,
    } = props;

    const hasRows = rows && rows.length > 0;
    const selectedRow = hasRows && rows[selectedRowIndex] ? rows[selectedRowIndex] : null;
    const selectedRowData = selectedRow ? getRowData({ row: selectedRow, index: selectedRowIndex, }) : null;

    const rowClickHandler = (index) => {
        if(onClickRow)
            onClickRow(index);
    };

    const getCellsCount = () => {
        let cellsCount = 0;
        rows.forEach((row, index) => {
            const rowData = getRowData({ row, index });
            cellsCount += rowData.getCellsAmount(row);
        });
        return cellsCount;
    };

    const renderRows = ({ articles }) => {
        let cellsRendered = 0;

        const rowsArray = rows ? rows.map( ( row, index ) => {
            const offset = cellsRendered;
            if( offset >= articles.length && !showEmpty )
                return;

            const rowData = getRowData({ row, index });

            const RowComponent = rowData.component;
            const isSelected = index == selectedRowIndex;
            let className = `articles-row ${isSelected ? 'selected' : ''}`;
            const isFirst = index == 0;
            const isLast = index == rows.length - 1;
            let balancerText;

            if(row.use_balacer_articles){
                className += " balanced-row";
                if(row.balancer_allow_fallback){
                    balancerText = "Los artículos que se visualizan en esta fila son los que se mostrarían en el caso de que no se encuentren otros en el balanceador.";
                    className += " with-fallback";
                }
                else {
                    balancerText = "Esta fila muestra artículos del balanceador. En caso de que no se encuentren, no se mostrará.";
                    className += " no-fallback";
                }
            }

            // Only count the row cells if it uses articles from the filters
            if(!row.use_balacer_articles || row.balancer_allow_fallback)
                cellsRendered += rowData.getCellsAmount(row);


            return (
                <div className={className} onClick = { () => rowClickHandler({
                    row,
                    index,
                    RowComponent,
                    Controls: rowData.Controls,
                }) }>
                    {row.use_balacer_articles &&
                    <Tooltip text = {balancerText}>
                        <div class="balancer-overlay">
                            <img src={balancerImage}/>
                        </div>
                    </Tooltip>
                    }
                    { showControls &&
                    <>
                        <div className="row-controls">
                            { rows.length > 1 &&
                            <div className="remove-btn" onClick = { () => onRemoveRow ? onRemoveRow({ row, index }) : null }><Icon icon="no"/></div>
                            }
                        </div>
                        {isSelected &&
                            <div className="movement-arrows">
                                <div className="arrows">
                                    {!isFirst &&
                                    <div className="arrow-up" onClick = { () => onMoveRow ? onMoveRow({
                                        row,
                                        indexFrom: index,
                                        indexTo: index - 1
                                    }) : null }><Icon icon="arrow-up-alt2"/></div>
                                    }
                                    {!isLast &&
                                    <div className="arrow-down" onClick = { () => onMoveRow ? onMoveRow({
                                        row,
                                        indexFrom: index,
                                        indexTo: index + 1
                                    }) : null }><Icon icon="arrow-down-alt2"/></div>
                                    }
                                </div>
                            </div>
                        }
                    </>
                    }
                    <RowComponent
                        { ...row }
                        articles = { articles }
                        offset = { offset }
                        isSelected = { isSelected }
                    />
                </div>
            );
        }) : [];

        return (
            <div className="ta-articles-rows">
                {rowsArray}
            </div>
        );
    };

    const renderRowControls = (args = {}) => {
        const {
            Controls: RowControls,
        } = selectedRowData ? selectedRowData : {};

        const {
            balancerFilter = false,
            updateRow,
        } = args;

        const changeRowFormat = ({ row, format }) => {
            const { defaultConfig } = getRowData({ row: { format } });
            const updatedRow = {
                use_balacer_articles: false,
                balancer_allow_fallback: false,
                ...row,
                ...defaultConfig,
                format,
            };
            updateRow(selectedRowIndex, updatedRow);
        };

        return (
            <>
                {selectedRow &&
                <>
                    <SelectControl
                        label="Formato"
                        value={ selectedRow.format }
                        options={ [
                            { label: 'Miscelanea', value: 'miscelanea' },
                            { label: 'Común', value: 'common' },
                            { label: 'Slider', value: 'slider' },
                        ] }
                        onChange={ ( format ) => changeRowFormat({row: selectedRow, format}) }
                    />
                    {balancerFilter &&
                    <>
                        <ToggleControl
                            label={"Usar artículos del balanceador"}
                            checked={ selectedRow.use_balacer_articles }
                            onChange={(value) => updateRow(selectedRowIndex, {...selectedRow, use_balacer_articles: value}) }
                        />
                        {selectedRow.use_balacer_articles && false && // this is no longer used, since the balancer articles get render from the client
                        <ToggleControl
                            label={"Si el balanceador no tiene artículos suficientes, mostrar los correspondientes a los filtros establecidos."}
                            checked={ selectedRow.balancer_allow_fallback }
                            onChange={(value) => updateRow(selectedRowIndex, {...selectedRow, balancer_allow_fallback: value}) }
                        />
                        }
                    </>
                    }
                    { RowControls &&
                    <RowControls
                        row = { selectedRow }
                        index = { selectedRowIndex }
                        onUpdate = { ({row, index}) => updateRow(index, row) }
                    />
                    }
                </>
                }
            </>
        )

    }

    return {
        renderRows,
        renderRowControls,
        selectedRowData,
        getCellsCount,
    }
};

function getRowData({row, index}){
    const { format } = row;
    let rowData;
    switch (format) {
        case 'common':
            rowData = commonRow;
        break;
        case 'slider':
            rowData = sliderRow;
        break;
        default:
            rowData = miscelaneaRow;
        break;
    }

    return rowData;
};


export default useTAArticlesRowsContainer;
