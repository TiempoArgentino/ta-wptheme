import { fieldsScheme, forEachField, getMatchingBalancerData, getUserPreference } from './scheme';

export async function loadArticlePreviewIcons({ elem, preferences }){
    const $ = jQuery;
    try {
        let articleBalancerData;
        if($(elem).data('icons') && (articleBalancerData = $(elem).data('balancer')) ){
            const userPreference = preferences ?? await getUserPreference();
            const hasPreferences = userPreference && userPreference.info;
            if(hasPreferences){
                const matches = getMatchingBalancerData(userPreference, articleBalancerData);
                if(matches){
                    if(matches['authors']?.length)
                        $(elem).find(`[data-icon="author"]`).fadeIn();
                    if(matches['locations']?.length)
                        $(elem).find(`[data-icon="location"]`).fadeIn();
                    if(matches['topics']?.length || matches['cats']?.length || matches['tags']?.length)
                        $(elem).find(`[data-icon="favorite"]`).fadeIn();
                }
            }
        }
    }
    catch (e) {
        console.log(e);
    }
}
