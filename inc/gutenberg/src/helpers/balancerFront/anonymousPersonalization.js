export function getCloudLocalStorage(){
    const localStorageData = window.localStorage.getItem('taBalancerTagsCloud');
    return localStorageData ? JSON.parse(localStorageData) : {
        ids: [],
        denied: false,
    };
}

export function getCloudLocalStorageField(field){
    const localStorageData = getCloudLocalStorage();
    return localStorageData[field];
}

export function getCloudLocalStorageIds(){
    return getCloudLocalStorageField('ids');
}

export function updateCloudLocalStorage(data){
    window.localStorage.setItem('taBalancerTagsCloud', JSON.stringify(data));
}

export function updateCloudLocalStorageField(field,data){
    const localStorageData = getCloudLocalStorage();
    localStorageData[field] = data;
    updateCloudLocalStorage(localStorageData);
}
/**
*   Indicates if the user has already completed the tags personalization.
*/
export const userCompletedPersonalization = () => getCloudLocalStorageIds()?.length > 0;

/**
*   Indicates if the user closed the tags cloud in a previous intance
*/
export function userDeniedPersonalization(){
    return getCloudLocalStorageField('denied');
}

/**
*   Updates local storage value of denied to true
*/
export function setUserDeniedPersonalization(){
    updateCloudLocalStorageField('denied', true);
}
