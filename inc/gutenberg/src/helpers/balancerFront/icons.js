import { fieldsScheme, forEachField, getMatchingBalancerData } from './scheme';

export async function loadArticlePreviewIcons(articlePreview){
    const $ = jQuery;
    try {
        const userPreference = await postsBalancer.loadPreferences();
        const hasPreferences = userPreference && userPreference.info;
        const articleBalancerData = $(articlePreview).data('balancer');

        if(hasPreferences && articleBalancerData){
            const matches = getMatchingBalancerData(userPreference, articleBalancerData);
            // console.log('Matching data:', getMatchingBalancerData(userPreference, articleBalancerData));
            if(matches['authors'].length){
                $(articlePreview).find(`[data-icon="author"]`).fadeIn();
            }
            if(matches['locations'].length){
                $(articlePreview).find(`[data-icon="location"]`).fadeIn();
            }
            if(matches['topics'].length){
                $(articlePreview).find(`[data-icon="favorite"]`).fadeIn();
            }
        }
    }
    catch (e) {
        console.log(e);
    }
}
