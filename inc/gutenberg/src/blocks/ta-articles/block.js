const { __ } = wp.i18n; // Import __() from wp.i18n
//const { Component, Fragment } = wp.element;
const { registerBlockType } = wp.blocks; // Import registerBlockType() from wp.blocks
const { InspectorControls } = wp.editor;
const { useState, useEffect, Fragment } = wp.element;
const { Spinner, PanelBody, Button, ToggleControl } = wp.components;
import arrayMove from 'array-move';
import TAContainer from '../../components/TAContainer/TAContainer';
import TAContainerControls from '../../components/TAContainerControls/TAContainerControls';
import useTAArticlesRowsContainer from '../../helpers/useTAArticlesRowsContainer/useTAArticlesRowsContainer';
import { useTAArticlesManager } from '../../helpers/ta-article/lr-articles.js';
import './css/editor.css';
// import './gallery';


registerBlockType( 'ta/articles', {
	// Block name. Block names must be string that contains a namespace prefix. Example: my-plugin/my-custom-block.
	title: __( 'Articulos', 'ta-genosha' ), // Block title.
	icon: 'media-document', // Block icon from Dashicons → https://developer.wordpress.org/resource/dashicons/.
	category: 'ta-blocks', // Block category — Group blocks together based on common traits E.g. common, formatting, layout widgets, embed.
	keywords: [
		__( 'La Razón' ),
		__( 'Genosha' ),
		__( 'Contenedor' ),
		__( 'Sección' ),
	],
	getEditWrapperProps(attributes) {
		return {
			'data-align': attributes.use_container ? 'full' : '',
		};
	},
	// The "edit" property must be a valid function.
	edit: function( props ) {
        const { attributes, setAttributes, className, isSelected, getAttribute } = props;
		const [ selectedRowIndex, setSelectedRowIndex ] = useState(0);
		const currentRow = attributes.rows[selectedRowIndex];

		const updateRow = ( index, newData ) => {
			const rows = attributes.rows.slice();
			rows.splice(index, 1, newData)
			setAttributes( {
				rows: rows,
			} );
		};

		const selectRow = ({ index }) => {
			if( selectedRowIndex == index)
				return;
			setSelectedRowIndex(index);
		};

		const moveRow = ({ indexFrom, indexTo }) => {
			if( (indexFrom == indexTo) || (!attributes.rows || !attributes.rows.length || !attributes.rows[indexFrom] || !attributes.rows[indexTo]) )
				return;
			const newOrderRows = arrayMove(attributes.rows, indexFrom, indexTo);
			setAttributes( {
				rows: newOrderRows,
			} );

			if( indexFrom == selectedRowIndex )
				selectRow({ index: indexTo });
		};

		const removeRow = ({index}) => {
			const rows = attributes.rows.slice();
			rows.splice(index, 1);
			setAttributes( {
				rows: rows,
			} );
		};

		const addRow = ({
			index = attributes.rows ? attributes.rows.length : 0
		} = {}) => {

		};

		const {
			renderRows,
			renderRowControls,
			selectedRowData,
			getCellsCount,
			addFormatDefaultAttributes,
		} = useTAArticlesRowsContainer({
			rows: attributes.rows,
			onMoveRow: moveRow,
			onClickRow: selectRow,
			onRemoveRow: removeRow,
			selectedRowIndex: selectedRowIndex,
			showEmpty: isSelected,
			showControls: isSelected,
		});

		const cellsCount = getCellsCount();

		useEffect( () => {
			if(!attributes.rows || attributes.rows.length <= 0 ){
				setAttributes({
					rows: [
						{
							format: 'miscelanea',
							cells: null,
						}
					],
				});
			}

		}, []);

		useEffect( () => {
			setAttributes({
				amount: cellsCount,
			});
		}, [cellsCount]);

		const {
			loadingArticles,
			articlesFetchError,
			articles,
			renderArticlesControls,
			isTermArticles,
			triggerFetch,
		} = useTAArticlesManager({
			attributes,
			setAttributes,
			extraQueryArgs: {
				post_status: ['publish', 'future'],
			},
			// taxonomiesFilters = {tag: true, section: true, author: true},
		});

		const {
			Controls: RowControls,
		} = selectedRowData ? selectedRowData : {};

		const ContainerComp = attributes.use_container ? TAContainer : Fragment;
		const usesTermFormat = isTermArticles && attributes.container.use_term_format;

        return (
			<>
				<ContainerComp
					attributes = {{
						...attributes.container,
						title: usesTermFormat ? isTermArticles.name : attributes.container.title,
					}}
					titleEditable = { usesTermFormat ? false : true }
					setAttributes = { (attr) => setAttributes({ container: {...container, ...attr}}) }
				>
					<div className={`${className} ta-articles-block`}>
						{ loadingArticles && <Spinner/> }
						{ !loadingArticles && !articlesFetchError && (!articles || articles.length == 0) &&
						<p>No hay articulos</p>
						}
						{ !loadingArticles && articlesFetchError &&
							<>
								<p>Ocurrió un error al intentar recuperar los artículos de este bloque.</p>
								<Button isPrimary onClick={ triggerFetch }>Reintentar</Button>
							</>
						}
						<div className="rows-container">
							{ renderRows({articles: articles}) }
							{ isSelected &&
							<div className="add-btn-container">
								<Button
									isPrimary
									onClick = { () => {
										setAttributes({
											rows: [ ...attributes.rows,
												{
													format: 'miscelanea',
													cells: [],
												},
											],
										})
									} }
								>Agregar fila</Button>
							</div>
							}
						</div>
					</div>
				</ContainerComp>
				<InspectorControls>
					{ articles && articles.length > cellsCount &&
					<p>Hay mas artículos de los que se pueden mostrar!!!</p>
					}
					<PanelBody
						title="Contenedor"
						icon="layout"
						initialOpen={false}
					>
						<ToggleControl
		                    label={"Usar contenedor"}
		                    checked={ attributes.use_container }
		                    onChange={(use_container) => setAttributes({use_container})}
		                />
						{ attributes.use_container &&
							<TAContainerControls
								attributes = { attributes.container }
								setAttributes = { ( newAttributes ) => {
									setAttributes({
										container: { ...attributes.container, ...newAttributes },
									});
								} }
								termControls = {true}
								isTermArticles = {isTermArticles}
							/>
						}
					</PanelBody>
					{ currentRow &&
					<PanelBody
						title="Fila"
						icon="layout"
						initialOpen={false}
					>
						{renderRowControls({ updateRow, balancerFilter: true })}
					</PanelBody>
					}

					{ renderArticlesControls({
						articlesFiltersProps: {
							amountFilter: false,
						},
					}) }

				</InspectorControls>
			</>
        );
	},
	// The "save" property must be specified and must be a valid function.
	save: function( { attributes } ) {
        return null;
	},
} );
