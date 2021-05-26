const { __ } = wp.i18n; // Import __() from wp.i18n
//const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { InnerBlocks, InspectorControls } = wp.editor;
const { SelectControl, CheckboxControl, TextControl } = wp.components;
import './css/editor.css';

registerBlockType( 'ta/container-with-header', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Sección con título', 'ta-genosha' ), // Block title.
	icon: 'media-document', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'ta-blocks', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'La Razón' ),
		__( 'Genosha' ),
		__( 'Contenedor' ),
		__( 'Sección' ),
	],
	// The "edit" property must be a valid function.
	edit: function( props ) {
        const { attributes, setAttributes, className, isSelected } = props;

        return (
            <div className={`${className} ta-container-with-header-block`}>
				KAAJAJAJAAJJAJA
            </div>
        );
	},
	// The "save" property must be specified and must be a valid function.
	save: function( { attributes } ) {
        return <InnerBlocks.Content />;
	},
} );
