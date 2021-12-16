const { useState, useRef } = wp.element;

import {useRbTerms, rbTaxQuery} from '../../helpers/rb-terms/rb-terms.js';

/**
*   Genera un objecto con datos para las taxonomias de articulo que se quieran.
*   @return {object}
*        @property {object} micrositio
*        @property {object} tag
*        @property {object} section
*        @property {object} author
*        @property {object} taxQuery                Filtro de tax en base de los datos generados, formateado para ser usado en un WP_Query
*   Cada objecto de taxonomy tiene datos de los terms que se consiguieron de acuerdo a
*   termsQueryArgs que se proveyeron para dicha taxonomy.
*   Un mayor detalle de los datos que se guardan por taxonomy se encuentra en el hook 'useRbTerms'
*   Entre los datos estan:
*   @property {WP_Term[]}   termsData                   Array de terms con toda la info recibida desde el WP_Terms_Query.
*   @property {function}    setTermsData                Funcion para establecer nueva informacion de terms.
*
*/
export const useLRArticlesTaxonomies = (props = {}) => {
    const initialized = useRef(false);
    const unmutableProps = useRef();
    if(!initialized.current){
        unmutableProps.current = props.usage;
        initialized.current = true;
    }
    const {
        taxQueryRelation = 'OR',
        micrositioProps = {},
        tagProps = {},
        sectionProps = {},
        authorProps = {},
        /*Indica que datos se quieren usar. Por limitacion de hooks, estos datos son inmutables
        * desde el momento en el que se asignan */
        usage = {
            micrositio: false,
            tag: false,
            section: false,
            author: false,
        },
    } = props;
    const {micrositio: useSuplements, tag: useTags, section: useSections, author: useAuthors, } = unmutableProps.current;
    let finalData = {};
    let taxQuery = {};

    //Suplementos
    if(useSuplements){
        const {terms: micrositios = [], queryArgs: micrositiosQueryArgs = {}, fetchArgs: micrositiosFetchArgs = {}, required: micrositiosRequired = false} = micrositioProps;
        finalData.micrositio = useRbTerms("ta_article_micrositio", micrositios, {
            termsQueryArgs: {
                only_include: true,
                ...micrositiosQueryArgs,
                taxonomy: "ta_article_micrositio",
            },
            fetchArgs: micrositiosFetchArgs,
        });
        taxQuery["ta_article_micrositio"] = {
            required: micrositiosRequired,
            field: micrositiosQueryArgs.field,
            terms: micrositios,
        };
    }

    //Tags
    if(useTags){
        const {terms: tags = [], queryArgs: tagsQueryArgs = {}, fetchArgs: tagsFetchArgs = {}, required: tagsRequired = false} = tagProps;
        finalData.tag = useRbTerms("ta_article_tag", tags, {
            termsQueryArgs: {
                only_include: true,
                ...tagsQueryArgs,
                taxonomy: "ta_article_tag",
            },
            fetchArgs: tagsFetchArgs,
        });
        taxQuery["ta_article_tag"] = {
            required: tagsRequired,
            field: tagsQueryArgs.field,
            terms: tags,
        };
    }

    //Secciones
    if(useSections){
        const {terms: sections = [], queryArgs: sectionsQueryArgs = {}, fetchArgs: sectionsFetchArgs = {}, required: sectionsRequired = false} = sectionProps;
        finalData.section = useRbTerms("ta_article_section", sections, {
            termsQueryArgs: {
                only_include: true,
                ...sectionsQueryArgs,
                taxonomy: "ta_article_section",
            },
            fetchArgs: sectionsFetchArgs,
        });
        taxQuery["ta_article_section"] = {
            required: sectionsRequired,
            field: sectionsQueryArgs.field,
            terms: sections,
        };
    }

    //Secciones
    if(useAuthors){
        const {terms: authors = [], queryArgs: authorsQueryArgs = {}, fetchArgs: authorsFetchArgs = {}, required: authorsRequired = false} = authorProps;
        finalData.author = useRbTerms("ta_article_author", authors, {
            termsQueryArgs: {
                only_include: true,
                ...authorsQueryArgs,
                taxonomy: "ta_article_author",
            },
            fetchArgs: authorsFetchArgs,
        });
        taxQuery["ta_article_author"] = {
            required: authorsRequired,
            field: authorsQueryArgs.field,
            terms: authors,
        };
    }

    finalData.taxQuery = rbTaxQuery(taxQuery);
    return finalData;
}
