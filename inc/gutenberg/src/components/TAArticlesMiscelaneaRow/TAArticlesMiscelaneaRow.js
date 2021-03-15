import React, { useState, useEffect, useRef } from "react";
import TAArticlePreview from '../TAArticlePreview/TAArticlePreview';
import useArticleRowData from '../../helpers/useArticleRowData/useArticleRowData';
const { Spinner, RangeControl } = wp.components;
import './css/editor.css';

export function getCellsAmount(rowConfig){
    return 4;
}

const Controls = null;

const TAArticlesMiscelaneaRow = (props = {}) => {
    const {
        articles,
        cells,
        offset,
        isSelected,
    } = props;

    const {
        hasArticles,
        getCellData,
        className,
    } = useArticleRowData(props);

    const firstCellData = getCellData(0);
    const secondCellData = getCellData(1);
    const thirdCellData = getCellData(2);
    const forthCellData = getCellData(3);

    return (
        <div className={`articles-list miscelanea ${className}`}>
            <div className="column">
                <div className={ `cell large ${firstCellData.className}`}>
                    { firstCellData.article &&
                        <TAArticlePreview
                            article = { firstCellData.article }
                            size = "large"
                            orientation = "vertical"
                        />
                    }
                </div>
            </div>

            <div className="column">

                <div className={ `cell common ${secondCellData.className}`}>
                    { secondCellData.article &&
                        <TAArticlePreview
                            article = { secondCellData.article }
                            size = "common"
                            orientation = "horizontal"
                        />
                    }
                </div>

                <div className={ `cell common ${thirdCellData.className}`}>
                    { thirdCellData.article &&
                        <TAArticlePreview
                            article = { thirdCellData.article }
                            size = "common"
                            orientation = "horizontal"
                        />
                    }
                </div>

                <div className={ `cell common ${forthCellData.className}`}>
                    { forthCellData.article &&
                        <TAArticlePreview
                            article = { forthCellData.article }
                            size = "common"
                            orientation = "horizontal"
                        />
                    }
                </div>

            </div>
        </div>
    );

};

const data = {
    component: TAArticlesMiscelaneaRow,
    getCellsAmount,
    Controls,
};

export default data;
