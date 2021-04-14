import React from "react";
import './css/style.css';
const { TextControl, PanelBody } = wp.components;
const { useSelect } = wp.data;
const { useEntityProp } = wp.coreData;

/**
*   Generates a block that displays basic author information and controls to
*   update metavalue related to the author in the article
*/
const TAArticleAuthorMetaBlock = (props) => {
    const {
        author,
        onRemove,
    } = props;

    const postType = useSelect(
        ( select ) => select( 'core/editor' ).getCurrentPostType(),
        []
    );
    const [ meta, setMeta ] = useEntityProp(
        'postType',
        postType,
        'meta'
    );

    const metaFieldValue = meta && meta['ta_article_authors_rols'] ? meta['ta_article_authors_rols'] : {};
    const rol = metaFieldValue[author.term.term_id];
    function updateMetaValue( newRol ) {
        const mutatedValue = {...metaFieldValue};
        mutatedValue[author.term.term_id] = newRol;
        setMeta( { ...meta, 'ta_article_authors_rols': mutatedValue } );
    }

    const photoStyle = {
        backgroundImage: `url("${author.photo}")`,
    };

    return (
        <div className="ta-article-author-meta">
            <PanelBody
                title={author.name}
                icon="person"
                initialOpen={false}
            >
                <div className="content">
                    <div className="author-data">
                        <div className="photo-container">
                            <div className="photo" style = {photoStyle}></div>
                        </div>
                    </div>
                    <div className="meta-controls">
                        <div className="input-container">
                            <TextControl
                                label="Rol"
                                value={ rol }
                                onChange={ updateMetaValue }
                            />
                        </div>
                        <div className="remove-author" onClick = { onRemove ? onRemove : false }>
                            <p className="remove-btn">Remover Autor</p>
                        </div>
                    </div>
                </div>
            </PanelBody>
        </div>
    )
};

export default TAArticleAuthorMetaBlock;
