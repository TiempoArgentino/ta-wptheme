const { __ } = wp.i18n; // Import __() from wp.i18n
//const { Component, Fragment } = wp.element;
const { registerBlockType, createBlock } = wp.blocks; // Import registerBlockType() from wp.blocks
const { InnerBlocks, InspectorControls } = wp.editor;
const { CheckboxControl, RangeControl, PanelBody, PanelRow, SelectControl, TextControl } = wp.components;
const { useState } = wp.element;
const { useDispatch, useSelect, withDispatch  } = wp.data;

import './css/style.scss';

const ALLOWED_BLOCKS = [ 'rb-bootstrap/column' ];

const breakpoints = [
	{
		label: 'Extra Chico',
		value: 'xs',
		width: '<576px',
	},
	{
		label: 'Chico',
		value: 'sm',
		width: '≥576px',
	},
	{
		label: 'Medio',
		value: 'md',
		width: '≥768px',
	},
	{
		label: 'Largo',
		value: 'lg',
		width: '≥992px',
	},
	{
		label: 'Extra Largo',
		value: 'xl',
		width: '≥1200px',
	},
];

registerBlockType( 'rb-bootstrap/grid', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Grilla Bootstrap', 'lr-genosha' ), // Block title.
	icon: 'layout', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'layout', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'RB' ),
		__( 'Bootstrap' ),
		__( 'Grids' ),
		__( 'grilla' ),
		__( 'Column' ),
	],
	supports: {
		customClassName: false,
	},
	// The "edit" property must be a valid function.
	edit: withDispatch( (dispatch, ownProps, registry) => ({
        changeColumnsAmount(newAmount, oldAmount){
            const { clientId, setAttributes  } = ownProps;
    		const { replaceInnerBlocks } = dispatch( 'core/block-editor' );
    		const { getBlocks } = registry.select( 'core/block-editor' );
            let innerBlocks = getBlocks( clientId );
            //innerBlocks = [];
            //console.log( a );

			//Is adding
            if(newAmount > oldAmount){
                let block = createBlock('rb-bootstrap/column', {}, []);
                innerBlocks.push(block);
            }
			//Is removing
			else if(newAmount < oldAmount){
				innerBlocks.splice(newAmount);
			}

            replaceInnerBlocks( clientId, innerBlocks, false );
            setAttributes({ columns: newAmount });
        },
    }))( (props) => {
        const { attributes, setAttributes, className, isSelected, clientId, changeColumnsAmount } = props;
		const [ template, setTemplate ] = useState( null );

        const getTemplate = () => {
            let template = [];
            for(var i = 0; i < attributes.columns; i++){
                template.push(
                    [ 'rb-bootstrap/column', {}, [] ]
                );
            }
            //console.log(template);
            return template;
        };

        const blockClass = `rb-bootstrap-grid ${className} preview-${attributes.preview}`;
		const rowClass = `rb-bootstrap-row columns preview-${attributes.preview}`;
        return (
            <div className={blockClass}>
				<div className={rowClass}>
					<InnerBlocks
                        allowedBlocks={ ALLOWED_BLOCKS }
                        template={ getTemplate() }
                        templateLock='insert'
					/>
				</div>
				<InspectorControls>
                    <SelectControl
                        label="Punto de interrupción"
                        value={ attributes.preview }
                        options={ breakpoints }
                        onChange={(preview) => setAttributes({ preview })}
                    />
                </InspectorControls>
                <InspectorControls>
                    <RangeControl
                        label="Cantidad de columnas"
                        value={ attributes.columns }
                        onChange={(columns) => changeColumnsAmount(columns, attributes.columns)}
                        min={ 1 }
                        max={ 12 }
                    />
					<CheckboxControl
						label="Usar Container"
						checked={ attributes.use_container }
						onChange={() => setAttributes({use_container: !attributes.use_container})}
					/>
					<TextControl
						label="Clase(s) CSS adicional(es)"
						value={ attributes.css_classes }
						onChange={ ( css_classes ) => setAttributes( { css_classes } ) }
						type = 'text'
					/>
                </InspectorControls>
			</div>
        );
    }),
	// The "save" property must be specified and must be a valid function.
	save: function( { attributes } ) {
        return <InnerBlocks.Content />;
	},
} );
