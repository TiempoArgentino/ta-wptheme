export const fieldsScheme = {
    cats: {
        apiField: "sections",
        default: [],
    },
    tags: {
        apiField: "tags",
        default: [],
    },
    authors: {
        apiField: "authors",
        default: [],
    },
    locations: {
        apiField: "locations",
        default: [],
    },
    topics: {
        apiField: "topics",
        default: [],
    },
};


export function forEachField(cb){
    if(!cb)
        return;

    for (var balancerFieldName in fieldsScheme) {
        if (!fieldsScheme.hasOwnProperty(balancerFieldName))
            continue;

        cb({
            fieldName: balancerFieldName,
            fieldData: fieldsScheme[balancerFieldName]
        });
    }
}

export function getMatchingBalancerData(dataA, dataB){
    const dataAHasInfo = dataA && dataA.info;
    const dataBHasInfo = dataB && dataB.info;
    const matches = {};

    if(!dataAHasInfo || !dataBHasInfo)
        return matches;

    forEachField( ({ fieldName, fieldData }) => {
        const { default: defaultVal, apiField } = fieldData;
        const valueA = dataA.info[fieldName] ? dataA.info[fieldName] : [];
        const valueB = dataB.info[fieldName] ? dataB.info[fieldName] : [];
        const valuesMatches = arrayDif(valueA, valueB);

        matches[apiField] = valuesMatches && valuesMatches.length ? valuesMatches : [];
    } );

    return matches;
}

function arrayDif(array1, array2){
    var ret = [];
    array1.sort();
    array2.sort();
    for(var i = 0; i < array1.length; i += 1) {
        if(array2.indexOf(array1[i]) > -1){
            ret.push(array1[i]);
        }
    }
    return ret;
}
