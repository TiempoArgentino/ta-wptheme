import React, { useState, useEffect, useRef } from "react";
import TAArticlePreview from '../TAArticlePreview/TAArticlePreview';
import useArticleRowData from '../../helpers/useArticleRowData/useArticleRowData';
const { Spinner, RangeControl, ToggleControl } = wp.components;
import './css/editor.css';

function getCellsAmount({slides_amount, articlesAmount}){
    if(articlesAmount == 0)
        return 0;
    if( slides_amount == -1 || slides_amount >= articlesAmount )
        return articlesAmount;
    return slides_amount > 0 ? slides_amount : 4;
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
            <RangeControl
                label = "Cantidad"
                value = { row.slides_amount ? row.slides_amount : 4 }
                min = {1}
                max = {10}
                onChange={ (amount) => updateRow('slides_amount', amount) }
            />
        </>
    );
}


const TAArticlesSliderRow = (props = {}) => {
    const {
        articles,
        offset,
        cells,
        isSelected,
        slides_amount = 4,
    } = props;

    useEffect( () => {
        if(slidesAmount < currentIndex + 1)
            setCurrentIndex(slidesAmount - 1);
    }, [slidesAmount]);

    const {
        hasArticles,
        articlesLeft,
        getCellData,
        className,
    } = useArticleRowData(props);

    const slidesAmount = getCellsAmount({...props, articlesAmount: articlesLeft});
    const [currentIndex, setCurrentIndex] = useState(0);

    const authors = ({article}) => {
        return article.authors ? article.authors.map( ({name}, index) => {
            const text = index == article.authors.length - 1 ? name : `${name} / `;
            return <span className="author">{text}</span>
        }) : '';
    };

    const getBullets = () => {
        if( slidesAmount <= 1 )
            return null;

        const bullets = [];
        for (let i = 0; i < slidesAmount; i++) {
            const className = "bullet";
            if( i == currentIndex )
                className += " active";
            bullets.push(<div class={className} onClick = { () => setCurrentIndex(i) }>{i + 1}</div>);
        }

        return (
            <div class="slider-bullets">
                {bullets}
            </div>
        )
    }

    const getSlide = () => {
        const {article, className} = getCellData(currentIndex);
        const slideClass = article ? '' : 'empty';

        return (
            <div className={ `slide ${className}`}>
                <div class={`ta-article-slide ${slideClass}`}>
                    <div class="bkg-container">
                        {article &&
                        <div class="bkg-img" style = { { backgroundImage: `url("${article.thumbnail_common.url}")` } }></div>
                        }
                        <div class="bkg-overlay"></div>
                    </div>
                    <div class="content">
                        <div class="content-container">
                            {article &&
                            <div class="article-data">
                                <div className="article-data">
                                    { article.cintillo &&
                                    <div className="cintillo">
                                        <p>{article.cintillo}</p>
                                    </div>
                                    }
                                    { article.title &&
                                    <div className="title">
                                        <p>{article.title}</p>
                                    </div>
                                    }
                                    { article.authors &&
                                    <div className="authors">{authors({article})}</div>
                                    }
                                </div>
                            </div>
                            }
                            { getBullets() }
                        </div>
                    </div>
                </div>
            </div>
        )
    }

    return (
        <div className={`articles-list slider ${className}`}>
            {getSlide()}
        </div>
    );

};

const data = {
    component: TAArticlesSliderRow,
    getCellsAmount,
    Controls: Controls,
    defaultConfig: {
        slides_amount: 4,
    },
};

export default data;
