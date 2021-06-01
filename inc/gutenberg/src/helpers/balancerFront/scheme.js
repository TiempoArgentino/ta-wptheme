import { userCompletedPersonalization, userDeniedPersonalization, getCloudLocalStorageIds } from './anonymousPersonalization';

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
        apiField: "themes",
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
    const dataAHasInfo = dataA?.info;
    const dataBHasInfo = dataB?.info;
    const matches = {};

    if(!dataAHasInfo || !dataBHasInfo)
        return matches;

    forEachField( ({ fieldName, fieldData }) => {
        const { default: defaultVal, apiField } = fieldData;
        const valueA = dataA.info[fieldName] ?? [];
        const valueB = dataB.info[fieldName] ?? [];
        const valuesMatches = arrayDif(valueA, valueB);

        matches[fieldName] = valuesMatches?.length ? valuesMatches : [];
    } );

    return matches;
}

/**
*   Returns the user preference. This data is not ready to be passed to the API.
*   If data compatible with the latest articles is needed, use getUserPreferenceForAPI
*/
export async function getUserPreference(){
    let userPreference = {};
    // If logged and has selected tags from the tags cloud it doesn't use the data from the balancer (current post data, etc)
    if(!postsBalancerData.isLogged && userCompletedPersonalization()){
        userPreference = {
            info: {
                topics: getCloudLocalStorageIds(),
            },
        };
    }
    else{
        userPreference = await postsBalancer.loadPreferences();
    }

    return userPreference;
}

/**
*   Parses the user preferences from the balancer to ones compatible with the
*   TA latest articles API
*/
export async function getUserPreferenceForAPI(){
    return mapFromUserPreferenceToAPIFields( await getUserPreference() );
}

/**
*   Returns an array of ids of the articles visisted by the user
*/
export async function getUserViewedArticlesIds(){
    const balancerData = await getUserPreference();
    return balancerData?.info?.posts ?? [];
}

/**
*	Takes the user preference data from the balancer, and maps its fields to
*   the one expected by the Tiempo Argentino latest articles API
*/
export function mapFromUserPreferenceToAPIFields(userPreference){
    const taPreferences = {};

    forEachField( ({ fieldName, fieldData }) => {
        const { default: defaultVal, apiField } = fieldData;
        const userPrefValue = userPreference?.info[fieldName] ?? null;
        taPreferences[apiField] = userPrefValue ?? defaultVal;
    } );

    return taPreferences;
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
