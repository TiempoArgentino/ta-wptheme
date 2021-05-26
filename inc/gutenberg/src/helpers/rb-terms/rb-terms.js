const { useState } = wp.element;
import {useTermsFetch} from '../../helpers/rb-terms-fetch-hoc/rb-terms-fetch-hoc.js';

/**
*   Variables and functionalities that facilitates the managment of terms data
*   @property {WP_Term[]}   termsData                       Terms array
*   @property {function}    setTermsData                    Functions to change the 'termsData'
*   @property {object}      termsFetchStatus                Current status of the terms fetch
*       @property {bool}    loading
*       @property {bool}    error
*   @property {bool}        termsChanged                    If the terms had changed from the original data
*                                                           provided through the 'initialTerms' arg
*   @property {object}      taxQuery                        Tax query filter in base of the tax data. To use in WP_Query
*   @property {int}         totalPages                      Amount of pages for the terms query
*/
export function useRbTerms(taxonomy, termsQueryableData, args = {}){
    const {termsQueryArgs = {}, fetchArgs = {}, field = 'term_id', initialTerms = []} = args;
    const [termsChanged, setTermsChanged] = useState(false);
    const [termsStateData, setTermsDataState] = useState(initialTerms);
    const setTermsData = (stateValue) => {
        setTermsDataState(stateValue);
        termsChanged ? false : setTermsChanged(true);
    };

    //Terms in
    let terms_in = {};
    if(field == 'term_id')
        terms_in.include = termsQueryableData;
    else
        terms_in[field] = termsQueryableData;

    //Terms query
    const termsQuery = {
        ...termsQueryArgs,
        ...terms_in,
    };

    //Terms Fetch
    const {terms: termsFetchData, status: termsFetchStatus, totalPages} = useTermsFetch({termsQueryArgs: termsQuery, fetchArgs});

    //Tax query for WP_Query
    const taxQuery = {
        taxonomy: taxonomy,
        field: field,
        terms: termsQueryableData,
    };

    //Return
    const termsData = termsChanged ? termsStateData : termsFetchData;
    return {
        termsData, termsFetchData, termsFetchStatus, termsChanged, termsStateData, setTermsData, taxQuery, totalPages, terms_in
    };
}

export function taxQueryArgs(relation = 'OR', taxQueries = []){
    const finalQuery = {};
    let count = 0;
    taxQueries.forEach((taxQuery) => {
        if(taxQuery.terms && taxQuery.terms.length){
            finalQuery[count] = taxQuery;
            count++;
        }
    });
    if(count > 1)
        finalQuery.relation = relation;
    return finalQuery;
}

/**
*   Devuelve una taxonomies query a usar en un WP_Query de articulos, en base a los
*   siguientes parametros
*   @param {array[]} terms                                  Array de terms tipo [ 'tax_id' => [124,626,34]]
*                                                           Se puede optar por pasar en vez de un array de terms, un array
*                                                           con mas opciones, las cuales se detallan a continuacion.
*           @param {mixed[]} terms                          Terms de la taxonomia. Tienen que corresponder al valor pasado por
*                                                           la opcion 'field'
*           @param {string} field                           Indica a que field del term se refieren los valores pasados por $terms
*                                                           Por default es 'term_id'
*           @param {bool} required                          Indica si la query de la taxonomia es obligatoria. Esto mete a esta taxonomia
*                                                           en una query con relacion 'AND', junto a las demas taxonomias obligatorias.
*   @return {mixed[]}
*/
export function rbTaxQuery(terms){
    let finalQuery = {};
    let disjunctQuery = {};
    let requiredQuery = {};

    let reqCount = 0;
    let disCount = 0;
    for (var taxName in terms) {
        if (!terms.hasOwnProperty(taxName))
            continue;

        const taxData = terms[taxName];
        const taxTerms = Array.isArray(taxData) ? taxData : taxData.terms;
        if(!taxTerms || (Array.isArray(taxTerms) && !taxTerms.length))
            continue;

        const taxQuery = {
            taxonomy: taxName,
            terms: taxTerms,
            field: taxData.hasOwnProperty("field") && taxData.field ? taxData.field : 'term_id',
        };

        if(taxData.hasOwnProperty("required") && taxData.required){
            requiredQuery[reqCount] = taxQuery;
            reqCount++;
        }
        else{
            disjunctQuery[disCount] = taxQuery;
            disCount++;
        }
    }

    if(requiredQuery[reqCount - 1]){//If there are required terms
        finalQuery = requiredQuery;
        finalQuery.relation = 'AND';
    }

    if(disjunctQuery[disCount - 1]){
        disjunctQuery.relation = 'OR';
        if(finalQuery.relation != 'AND')//if the query is empty (no required terms)
            finalQuery = disjunctQuery;
        else
            finalQuery['disjuntQuery'] = disjunctQuery;
    }


    return finalQuery;
}
