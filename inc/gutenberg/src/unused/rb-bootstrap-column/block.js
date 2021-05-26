const { __ } = wp.i18n; // Import __() from wp.i18n
//const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { InnerBlocks, InspectorControls } = wp.editor;
const { CheckboxControl, RangeControl, PanelBody, PanelRow, Button } = wp.components;
const { useState, } = wp.element;
const { createHigherOrderComponent } = wp.compose;

import './css/style.scss';

const breakpoints = {
	xs: {
		label: 'Extra Chico',
		value: 'xs',
		class: '',
		width: '<576px',
	},
	sm: {
		label: 'Chico',
		value: 'sm',
		class: '-sm',
		width: '≥576px',
	},
	md: {
		label: 'Medio',
		value: 'md',
		class: '-md',
		width: '≥768px',
	},
	lg: {
		label: 'Largo',
		value: 'lg',
		class: '-lg',
		width: '≥992px',
	},
	xl: {
		label: 'Extra largo',
		value: 'xl',
		class: '-xl',
		width: '≥1200px',
	},
};

const withClientIdClassName = createHigherOrderComponent( ( BlockListBlock ) => {
    return ( props ) => {
		const {attributes, clientId} = props;

		if(props.block.name != 'rb-bootstrap/column')
			return <BlockListBlock { ...props } className={ "block-" + clientId } />;

		let colClass = 'rb-bs-col-block ';

		for (let breakCode in breakpoints){
			if(breakpoints.hasOwnProperty(breakCode) && attributes.hasOwnProperty(`${breakCode}-size`)){
				if(attributes[`${breakCode}-size`] == 0)
					continue;
				const breakpoint = breakpoints[breakCode];
				const size = attributes[`${breakCode}-size`];
				colClass += `rb-bs-col-block${breakpoint.class}-${size} `;
			}
		}

		console.log(colClass);
        return <BlockListBlock { ...props } className={ "block-" + clientId + ` ${colClass}` } />;
    };
}, 'withClientIdClassName' );

wp.hooks.addFilter( 'editor.BlockListBlock', 'rb-bootstrap/column', withClientIdClassName );


registerBlockType( 'rb-bootstrap/column', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Bootstrap Columna', 'lr-genosha' ), // Block title.
	icon: 'align-center', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'layout', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'RB' ),
		__( 'Bootstrap' ),
		__( 'Grids' ),
		__( 'columna' ),
		__( 'Column' ),
	],
	parent: [ 'rb-bootstrap/grid' ],
	// The "edit" property must be a valid function.
	edit: function( props ) {
        const { attributes, setAttributes, className, isSelected, clientId } = props;

		const [ template, setTemplate ] = useState( null );
		const blockClass = `rb-bootstrap-column-block ${className}`;

		const setResponsiveAttribute = (breakCode, field, value) => {
			let newAttr = {};
			newAttr[`${breakCode}-${field}`] = value;
			setAttributes(newAttr);
		};

		const getResponsiveAttribute = (breakCode, field) => { return attributes[`${breakCode}-${field}`]; }

		const responsiveControls = () => {
			const controlGroups = [];
			for (let breakCode in breakpoints){
				if(breakpoints.hasOwnProperty(breakCode)){
					const breakpoint = breakpoints[breakCode];
					controlGroups.push(
						<PanelBody
				            title={breakpoint.label + ` (${breakpoint.width})`}
				            icon="welcome-widgets-menus"
				            initialOpen={ false }
				        >
							<RangeControl
								label="Tamaño (0 es auto)"
								value={ getResponsiveAttribute(breakCode, 'size') }
								onChange={(size) => setResponsiveAttribute(breakCode, 'size', size)}
								min={ 0 }
								max={ 12 }
							/>
				        </PanelBody>
					);
				}
			}
			// controlGroups.push(
			// <PanelBody
			// 	title={'Extra small'}
			// 	icon="welcome-widgets-menus"
			// 	initialOpen={ true }
			// >
			// 	<RangeControl
			// 		label="Size (0 is auto)"
			// 		value={ attributes.xs }
			// 		onChange={(size) => setAttributes({xs: size})}
			// 		min={ 0 }
			// 		max={ 12 }
			// 	/>
			// </PanelBody>
			// );
			return controlGroups;
		};

        return (
            <div className={blockClass}>
				{attributes.test &&
				<div className="test">
					<p>{attributes.responsive.xs.size}</p>
					<p>{attributes.test}</p>
				</div>
				}
				<InnerBlocks
					templateLock={false}
				/>
				<InspectorControls>
					{responsiveControls()}
				</InspectorControls>
			</div>
        );
	},
	// The "save" property must be specified and must be a valid function.
	save: function( { attributes } ) {
        return <InnerBlocks.Content />;
	},
} );
