import { fieldsScheme, forEachField, getMatchingBalancerData } from '../../helpers/balancerFront/scheme';
import { loadArticlePreviewIcons } from '../../helpers/balancerFront/icons';

( async ($) => {
    try {
        const userPreference = await postsBalancer.loadPreferences();
        const hasPreferences = userPreference && userPreference.info;

        if(hasPreferences){
            $(document).ready(function(){
                const articlesPreviews = document.querySelectorAll(".article-preview[data-icons]");
                articlesPreviews.forEach(articlePreview => loadArticlePreviewIcons({ elem: articlePreview }));
            })
        }
    }
    catch (e) {
        console.log(e);
    }
})(jQuery)
