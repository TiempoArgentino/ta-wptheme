import { fieldsScheme, forEachField, getMatchingBalancerData } from './scheme';

export async function loadArticlePreviewIcons({ elem, preferences, }){
    const $ = jQuery;
    try {
        const userPreference = preferences ? preferences : await postsBalancer.loadPreferences();
        const hasPreferences = userPreference && userPreference.info;
        const articleBalancerData = $(elem).data('balancer');
        if(hasPreferences && articleBalancerData){
            const matches = getMatchingBalancerData(userPreference, articleBalancerData);
            if(matches){
                if(matches['authors'].length)
                    $(elem).find(`[data-icon="author"]`).fadeIn();
                if(matches['locations'].length)
                    $(elem).find(`[data-icon="location"]`).fadeIn();
                if(matches['themes'].length)
                    $(elem).find(`[data-icon="favorite"]`).fadeIn();
            }
        }
    }
    catch (e) {
        console.log(e);
    }
}
