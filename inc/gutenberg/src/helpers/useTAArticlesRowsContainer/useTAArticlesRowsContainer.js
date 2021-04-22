import React, { useState, useEffect, useRef } from "react";
import sliderRow from '../../components/TAArticlesSliderRow/TAArticlesSliderRow';
import miscelaneaRow from '../../components/TAArticlesMiscelaneaRow/TAArticlesMiscelaneaRow';
import commonRow, { getRowCellsAmount as commonRowCellsAmount } from '../../components/TAArticlesCommonRow/TAArticlesCommonRow';
const { Spinner, Icon, SelectControl } = wp.components;
import './css/editor.css';

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
            const className = `articles-row ${isSelected ? 'selected' : ''}`;
            const isFirst = index == 0;
            const isLast = index == rows.length - 1;
            cellsRendered += rowData.getCellsAmount(row);

            return (
                <div className={className} onClick = { () => rowClickHandler({
                    row,
                    index,
                    RowComponent,
                    Controls: rowData.Controls,
                }) }>
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

    const changeRowFormat = ({ row, format }) => {
        const { defaultConfig } = getRowData({ row: { format } });
        const updatedRow = { ...row, ...defaultConfig, format };
        updateRow(selectedRowIndex, updatedRow);
    };

    const renderRowControls = () => {
        const {
            Controls: RowControls,
        } = selectedRowData ? selectedRowData : {};

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
                        onChange={ ( format ) => changeRowFormat({row: selectedRowIndex, format}) }
                    />
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
