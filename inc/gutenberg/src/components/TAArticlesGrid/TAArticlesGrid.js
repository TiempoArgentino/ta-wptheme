import React, { useState, useEffect, useRef } from "react";
import TAArticlePreview from '../TAArticlePreview/TAArticlePreview';
const { InspectorControls } = wp.editor;
const { PanelBody, Spinner, RangeControl } = wp.components;
import './css/editor.css';

const TAArticlesGrid = (props = {}) => {
    const {
        articles,
        setAttribute,
        attributes = {},
        className = '',
    } = props;

    const controlChange = (attribute, value) => {
        if(setAttribute)
            setAttribute(attribute, value);
    };

    const getGrid = () => {
        if(!articles)
            return '';
        const articlesAmount = articles.length;
        const articlesLeft = articles.length % attributes.cells_per_row;

        return (
            <div className="articles">
                {
                    articles.map( (article, index) => {
                        const flexPerc = index < articlesLeft ? 100 / articlesLeft : 100 / attributes.cells_per_row ;
                        const containerStyle = {
                            flex: `${flexPerc}%`,
                            width: `${flexPerc}%`,
                        }

                        return (
                            <div className="article-preview-container" style = {containerStyle}>
                                <TAArticlePreview
                                    article = { article }
                                    key = { article.ID }
                                />
                            </div>
                        );
                    })
                }
            </div>
        );
    };

    return (
        <>
            <div className={`${className} ta-articles-grid`}>
                { articles &&
                <>
                    {getGrid()}
                </>
                }
            </div>
        </>
    );
};

export default TAArticlesGrid;
