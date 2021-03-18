import React, { useState, useEffect, useRef } from "react";
import './css/editor.css';

const TAArticlePreview = (props) => {
    const {
        type = `common`, //common - author
        size = `common`,
        orientation = `vertical`,
        article = null,
        placeholder = null,
    } = props;

    const getClassName = () => {
        let className = ``;
        if(orientation == 'horizontal'){
            className += ' horizontal';
        }
        if( size ){
            // if( orientation == 'horizontal' )
            //     className += ` horizontal-${size}`;
            // else
                className += ` ${size}`;
        }
        if( article.isopinion )
            className += ` opinion`;
        return className;
    };

    const authors = () => {
        return article.authors ? article.authors.map( ({name}, index) => {
            const text = index == article.authors.length - 1 ? name : `${name} / `;
            return <span className="author">{text}</span>
        }) : '';
    };

    const opinionPreview = () => {
        const author = article.first_author ? article.first_author : null;

        if(!author)
            return(
                "Articulo de opinion sin autor!!!"
            );

        const photoStyle = {
            backgroundImage: `url("${author.photo}")`,
        };

        return (
            <>
                <div class="author-photo" style = {photoStyle}></div>
                <div class="article-data">
                    { article.title &&
                    <>
                        <div className="title">
                            <p>“{article.title}”</p>
                        </div>
                        <div class="separator"></div>
                    </>
                    }
                    <div class="authors">
                        <span class="author">{author.name}</span>
                    </div>
                </div>
            </>
        );
    };

    const getPreview = () => {
        if( article ){
            const thumbnailStyle = {
                backgroundImage: `url("${article.thumbnail_common.url}")`,
            };

            if( article.isopinion )
                return opinionPreview();

            return (
                <>
                    <div className="article-thumbnail" style = {thumbnailStyle}></div>
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
                        { article.excerpt && false &&
                        <div className="excerpt">
                            <p>{article.excerpt}</p>
                        </div>
                        }
                        { article.authors &&
                        <div className="authors">{authors()}</div>
                        }
                    </div>
                </>
            );
        }
        return '';
    };


    return (
        <div className={`ta-article-preview ${getClassName()}`}>
            {getPreview()}
        </div>
    );

};

export default TAArticlePreview;
