import {
    getCloudLocalStorage,
    getCloudLocalStorageField,
    getCloudLocalStorageIds,
    updateCloudLocalStorage,
    updateCloudLocalStorageField,
    userCompletedPersonalization,
    userDeniedPersonalization,
    setUserDeniedPersonalization,
} from '../../helpers/balancerFront/anonymousPersonalization';
const $ = jQuery;
const selectedTags = [];

function showTagsCloud() {
    $('#cloud-tag-container').slideDown();
}

function hideTagsCloud() {
    $('#cloud-tag-container').slideUp();
}

function indexOfTag(tagId) {
    return selectedTags.indexOf(tagId);
}

function addTag(tagId) {
    selectedTags.push(tagId);
}

function removeTag(tagId) {
    const tagIndex = indexOfTag(tagId);
    if (tagIndex != -1)
        selectedTags.splice(tagIndex, 1);
}

function storeSelectionInLocalStorage() {
    updateCloudLocalStorageField('ids', selectedTags);
}

export function completeSelection() {
    if (selectedTags.length <= 0)
        return false;
    storeSelectionInLocalStorage();
    return true;
}

if (typeof window.postsBalancer !== 'undefined') {

    try {
        if (userCompletedPersonalization() || userDeniedPersonalization()) {
            $('#cloud-tag-container').remove();
        }
        else {
            showTagsCloud();

            $(document).on('click', '#cloud-tag-container .tag', function () {
                const tagId = $(this).data('id');
                if ($(this).hasClass('active')) {
                    removeTag(tagId);
                    $(this).removeClass('active');
                }
                else {
                    addTag(tagId);
                    $(this).addClass('active');
                }

                if (selectedTags.length > 0)
                    $('#listo-cloud').removeClass('not-active');
                else
                    $('#listo-cloud').addClass('not-active');
            });

            $(document).on('click', '#close-cloud-tag', function () {
                setUserDeniedPersonalization();
                hideTagsCloud();
            });

            $(document).on('click', '#listo-cloud', function () {
                if (completeSelection())
                    hideTagsCloud();
            });

            // TODO: This needs to be refactored
            $(document).ready(function () {
                if ($("#cloud-tag-topics").length) {
                    var $div = $("#cloud-tag-topics .tag"); //tags
                    
                    var total = parseInt($div.length); //total tags

                    if ($div.length >= 10) { //if tags count > than total, show only first 10

                        var sliceDiv = 10;

                        $div.slice(sliceDiv, total).removeClass("d-flex").addClass("d-none"); 

                        $("#ver-mas-cloud").on("click", function () {

                            if (parseInt($("#cloud-tag-topics .tag:visible").length) >= total) {                              
                                $(this).addClass('d-none');
                                return;
                            }

                            sliceDiv -= 20;
                            $div.slice(sliceDiv, total).removeClass("d-none").addClass("d-flex");

                        });
                    }
                }
            });
        }

    }
    catch (e) {
        console.log(e);
    }

}
