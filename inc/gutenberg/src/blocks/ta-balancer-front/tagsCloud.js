const $ = jQuery;
const selectedTags = [];

function showTagsCloud(){
    $('#cloud-tag-container').slideDown();
}

function hideTagsCloud(){
    $('#cloud-tag-container').slideUp();
}

function indexOfTag(tagId){
    return selectedTags.indexOf(tagId);
}

function addTag(tagId){
    selectedTags.push(tagId);
}

function removeTag(tagId){
    const tagIndex = indexOfTag(tagId);
    if(tagIndex != -1)
        selectedTags.splice(tagIndex, 1);
}

function completeSelection(){
    if(selectedTags.length <= 0)
        return false;
    storeSelectionInLocalStorage();
    return true;
}

function getCloudLocalStorage(){
    const localStorageData = window.localStorage.getItem('taBalancerTagsCloud');
    return localStorageData ? JSON.parse(localStorageData) : {
        ids: [],
        denied: false,
    };
}

function getCloudLocalStorageField(field){
    const localStorageData = getCloudLocalStorage();
    return localStorageData[field];
}

export function getCloudLocalStorageIds(){
    return getCloudLocalStorageField('ids');
}

function updateCloudLocalStorage(data){
    window.localStorage.setItem('taBalancerTagsCloud', JSON.stringify(data));
}

function updateCloudLocalStorageField(field,data){
    const localStorageData = getCloudLocalStorage();
    localStorageData[field] = data;
    updateCloudLocalStorage(localStorageData);
}

function storeSelectionInLocalStorage(){
    updateCloudLocalStorageField('ids', selectedTags);
}

/**
*   Indicates if the user has already completed the tags personalization.
*/
export function userCompletedPersonalization(){
    const storedIds = getCloudLocalStorageIds();
    return storedIds && storedIds.length;
}

/**
*   Indicates if the user closed the tags cloud in a previous intance
*/
export function userDeniedPersonalization(){
    return getCloudLocalStorageField('denied');
}

/**
*   Updates local storage value of denied to true
*/
function setUserDeniedPersonalization(){
    updateCloudLocalStorageField('denied', true);
}

try {
    if(userCompletedPersonalization() || userDeniedPersonalization()){
        $('#cloud-tag-container').remove();
    }
    else{
        showTagsCloud();

        $(document).on('click', '#cloud-tag-container .tag', function(){
            const tagId = $(this).data('id');
            if( $(this).hasClass('active') ){
                removeTag(tagId);
                $(this).removeClass('active');
            }
            else{
                addTag(tagId);
                $(this).addClass('active');
            }

            if(selectedTags.length > 0)
                $('#listo-cloud').removeClass('not-active');
            else
                $('#listo-cloud').addClass('not-active');
        });

        $(document).on('click', '#close-cloud-tag', function(){
            setUserDeniedPersonalization();
            hideTagsCloud();
        });

        $(document).on('click', '#listo-cloud', function(){
            completeSelection();
            hideTagsCloud();
        });

        // TODO: Esto hay que refactorizarlo
        $(document).ready(function() {
            if ($("#cloud-tag-topics").length) {
                var $div = $("#cloud-tag-topics .tag");
                if ($div.length > 6) {
                    $div.slice(6, 16).removeClass("d-flex").addClass("d-none");
                    $("#ver-mas-cloud").on("click", function() {
                        $div.slice(0, 16).removeClass("d-none").addClass("d-flex");
                    });
                }
            }
        });
    }

}
catch{

}
