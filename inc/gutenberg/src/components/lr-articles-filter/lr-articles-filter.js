const { Fragment } = wp.element;
const { PanelBody, Spinner, RangeControl, ToggleControl } = wp.components;

import RBTermsSelector from '../../components/rb-terms-selector/rb-terms-selector.js';
import styles from "./editor.css";

export const LRArticlesFilters = (props = {}) => {
    const {
        /**
        *   @property {object} taxonomiesData
        *   Taxonomies data. If an article tax is present in this object, the filter for that
        *   tax will be shown. The hook 'useLRArticlesTaxonomies' returns an object formated for
        *   this prop
        */
        taxonomiesData,
        onTermsChange = null,
        /**
        *   @property {bool} amountFilter - Indica si usar o no el filtro de cantidad de artículos
        */
        amountFilter = false,
        /**
        *   @property {json} amountFilterProps - Opciones extra para el filtro de cantidad de artículos
        *           @property {int} max - Cantidad maxima
        *           @property {int} min - Cantidad minima
        *           @property {int} onChange - Funcion a correr cuando cambia el valor del filtro. Recibe el valor.
        */
        amountFilterProps = null,
        micrositioProps = null,
        tagProps = null,
        sectionProps = null,
        requiredTaxonomies = false,
        onRequiredTermsChange = null,
        attributes = null,
        setAttributes = null,
        mostRecentFilter = false,
        /**
        *   @param {bool} toggleFiltersWithMostRecent - Indica que los filtros se deben ocultar
        *   si el de "usar articulos mas recientes" no esta marcado
        */
        toggleFiltersWithMostRecent = true,
        /**
        *   @param {function} onMostRecentToggle - funcion a correr cuando se cambia el filtro de
        *   'mas recientes'. Recibe un parametro que indica el valor del filtro
        */
        onMostRecentToggle = null,
        /**
        *   @param {string} layoutType - indica como se quiere que se vean los filtros
        */
        layoutType = 'common', //common - compressed
    } = props;

    const useAmountFilter = amountFilter || amountFilterProps;
    const {max: maxAmount, min: minAmount = 1} = amountFilterProps ? amountFilterProps : {};

    /**
    *   Devuelve si existe el campo name de attributes. Si no existe, devuelve default.
    */
    const getAttribute = (name, def = null) => {
        return attributes && attributes.hasOwnProperty(name) ? attributes[name] : def;
    };

    /**
    *   Efecto que ocurre al cambiar los terms de las taxonomias
    *   @param {string} taxAttribute - Nombre del attribute que guarda los datos de
    *   la taxonomia
    *   @param {mixed[]} selectedTerms - Array de los terms por los cuales filtrar
    *   @param {function} setTermsData - Funcion para guardar los datos del term.
    *   De estos datos solo se guarda el term_id en el attribute
    */
    const termsChanged = (taxAttribute, selectedTerms, setTermsData) => {
        setTermsData(selectedTerms);
        if(setAttributes && attributes){
            let newAttrs = {};
            newAttrs[taxAttribute] = {...getAttribute(taxAttribute, {})};
            newAttrs[taxAttribute].terms = selectedTerms.map((term) => term.term_id);
            setAttributes(newAttrs);
        }
        else if(onTermsChange)
            onTermsChange(taxAttribute, selectedTerms);
    };

    const updateAttribute = ({ attribute, value }) => {
        if(setAttributes)
            setAttributes({[attribute]: value});
    }

    const requiredTermChange = (taxAttribute, isRequired) => {
        if(setAttributes && attributes){
            let newAttrs = {};
            newAttrs[taxAttribute] = {...getAttribute(taxAttribute, {})};
            newAttrs[taxAttribute].required = isRequired;
            setAttributes(newAttrs);
        }
        else if(onRequiredTermsChange)
            onRequiredTermsChange(taxAttribute, isRequired);
    };

    const onlyShowMostRecentFilter = () => {
        return toggleFiltersWithMostRecent && mostRecentFilter && !getAttribute('most_recent', false);
    };

    const RequiredTaxonomyCheckbox = ({taxName, taxObject}) => {
        const isChecked = getAttribute(taxName, {}).required;
        return (requiredTaxonomies &&
            <ToggleControl
                label={"Taxonomia obligatoria"}
                checked={ isChecked }
                onChange={() => requiredTermChange(taxName, !isChecked)}
            />
        );
    };

    const LRTermSelector = (props = {}) => {
        const {
            taxData = {},
            taxonomy = '',
            labels = {},
            taxonomyProps = {},
            attributeName = '',
        } = props;

        const {max = 0} = taxonomyProps ? taxonomyProps : {};

        return (
            <RBTermsSelector
                max={max}
                terms={taxData.termsData ? taxData.termsData : []}
                onSelectionChange={(selectedTerms) => termsChanged(attributeName, selectedTerms, taxData.setTermsData)}
                termsArgs={{
                    taxonomy: taxonomy,
                    hide_empty: false,
                    number: 10,
                }}
                labels = {{
                    noSelectedItems: labels.noSelectedItems,
                }}
                modalLabels = {{
                    submitLabel: labels.submitLabel,
                    openerLabel: labels.openerLabel,
                    modalTitle: labels.modalTitle,
                }}
                itemsSelectorLabels = {{
                    noSelectableItemsLabel: labels.noSelectableItemsLabel,
                    selectedItemsLabel: labels.selectedItemsLabel,
                    loadingItemsLabel: labels.loadingItemsLabel,
                }}
            />
        );
    };

    const getLayoutClass = () => {
        return layoutType == 'compressed' ? "compressed-layout" : '';
    }

    return (
        <div class={`lr-articles-filters-component ${getLayoutClass()}`}>
            {mostRecentFilter &&
                <ToggleControl
                    label={"Mas Recientes"}
                    checked={ getAttribute('most_recent', false) }
                    onChange={(value) => updateAttribute({ attribute: 'most_recent', value })}
                />
            }
            {!onlyShowMostRecentFilter() &&
                <Fragment>
                {useAmountFilter &&
                    <RangeControl
                        label = "Cantidad de articulos"
                        value={ getAttribute('amount', 0) }
                        onChange={(value) => updateAttribute({ attribute: 'amount', value })}
                        min={ minAmount }
                        max={ maxAmount }
                    />
                }
                {taxonomiesData &&
                    <div class="panel-bodies">
                        {taxonomiesData.micrositio &&
                            <PanelBody
                                title="Micrositios"
                                icon=""
                                initialOpen={taxonomiesData.micrositio.termsData && taxonomiesData.micrositio.termsData.length > 0}
                            >
                                <RequiredTaxonomyCheckbox taxName={'micrositios'} taxObject={taxonomiesData.micrositio}/>
                                <LRTermSelector
                                    taxData={taxonomiesData.micrositio}
                                    taxonomy={"ta_article_micrositio"}
                                    attributeName={"micrositios"}
                                    labels={{
                                    }}
                                    taxonomyProps={micrositioProps}
                                />
                            </PanelBody>
                        }
                        {taxonomiesData.section &&
                            <PanelBody
                                title="Secciones"
                                icon=""
                                initialOpen={taxonomiesData.section.termsData && taxonomiesData.section.termsData.length > 0}
                            >
                                <RequiredTaxonomyCheckbox taxName={'sections'} taxObject={taxonomiesData.section}/>
                                <LRTermSelector
                                    taxData={taxonomiesData.section}
                                    taxonomy={"ta_article_section"}
                                    attributeName={"sections"}
                                    labels={{
                                    }}
                                    taxonomyProps={sectionProps}
                                />
                            </PanelBody>
                        }
                        {taxonomiesData.tag &&
                            <PanelBody
                                title="Etiquetas"
                                icon=""
                                initialOpen={taxonomiesData.tag.termsData && taxonomiesData.tag.termsData.length > 0}
                            >
                                <RequiredTaxonomyCheckbox taxName={'tags'} taxObject={taxonomiesData.tag}/>
                                <LRTermSelector
                                    taxData={taxonomiesData.tag}
                                    taxonomy={"ta_article_tag"}
                                    attributeName={"tags"}
                                    labels={{
                                    }}
                                    taxonomyProps={sectionProps}
                                />
                            </PanelBody>
                        }
                        {taxonomiesData.author &&
                            <PanelBody
                                title="Autores"
                                icon=""
                                initialOpen={taxonomiesData.author.termsData && taxonomiesData.author.termsData.length > 0}
                            >
                                <RequiredTaxonomyCheckbox taxName={'authors'} taxObject={taxonomiesData.author}/>
                                <LRTermSelector
                                    taxData={taxonomiesData.author}
                                    taxonomy={"ta_article_author"}
                                    attributeName={"authors"}
                                    labels={{
                                    }}
                                    taxonomyProps={sectionProps}
                                />
                            </PanelBody>
                        }
                    </div>
                }
                </Fragment>
            }
        </div>
    );
}
