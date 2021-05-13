const { __ } = wp.i18n; // Import __() from wp.i18n
//const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { InnerBlocks, InspectorControls } = wp.editor;
const { SelectControl, CheckboxControl, TextControl } = wp.components;
import './css/editor.css';
import RBContentEditable from "../../components/rb-contenteditable/rb-contenteditable.js";

registerBlockType( 'ta/quote', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Cita', 'ta-genosha' ), // Block title.
	icon: 'format-quote', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'ta-blocks', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'Tiempo Argentino' ),
		__( 'Genosha' ),
		__( 'Cita' ),
        __( 'Quote' ),
	],
	// The "edit" property must be a valid function.
	edit: function( props ) {
        const { attributes, setAttributes, className, isSelected } = props;
		const placeholderQuote = "Agregar una cita!";
		const placeholderAuthor = "Autor de la cita (AGREGAR)";

        return (
			<>
				<div className = { `ta-quote-block ${className}` }>
					<div className="quote">
						“
						<input
							className="quote-input title"
							type="text"
							placeholder={placeholderQuote}
							value={attributes.quote}
							onChange={(e) => setAttributes({ quote: e.target.value })}
							size = { attributes.quote ? attributes.quote.length - 3: placeholderQuote.length - 3 }
						/>
						“
					</div>
					<div className="author">
						<input
							className="quote-input title"
							type="text"
							placeholder={placeholderAuthor}
							value={attributes.author}
							onChange={(e) => setAttributes({ author: e.target.value })}
							size = { attributes.author ? attributes.author.length - 3: placeholderAuthor.length - 3 }
						/>
					</div>
				</div>
			</>
        );
	},
	// The "save" property must be specified and must be a valid function.
	save: function( { attributes } ) {
        return null;
	},
} );
