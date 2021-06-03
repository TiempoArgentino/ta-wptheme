import { loadArticlePreviewIcons } from '../../helpers/balancerFront/icons';
const { apiFetch } = wp;
const $ = jQuery;
import ArticlesCommonRow from './elements/ArticlesCommonRow';
import ArticlesMiscelaneaRow from './elements/ArticlesMiscelaneaRow';
import ArticlesSliderRow from './elements/ArticlesSliderRow';

function failMisserably({elem, error}){
    console.log('ERROR:', error);
    $(elem).slideUp(400);
}

export async function renderBalancerArticlesRow({ elem, articlesArgs, rowArgs, cellsCount }){
    let ids = [];

    try {
        let balancedArticles = await fetchBalancedArticles({ articlesArgs });
        if(balancedArticles?.error !== undefined)
            failMisserably({ elem, error: balancedArticles.error });
        else{
            balancedArticles = balancedArticles?.length > 0 ? balancedArticles.slice(0, cellsCount) : [];
            if(balancedArticles.length <= 0)
                failMisserably({ elem, error: 'No articles found' });
            else {
                renderArticlesBlock({ elem, articles: balancedArticles, rowArgs });
                ids = balancedArticles.slice(0, cellsCount).map(article => article?.postId ?? null);
            }
        }

    } catch (error) {
        failMisserably({ elem, error });
    }

    return ids;
}

function fetchBalancedArticles({ articlesArgs }){
    var headers = new Headers();
    headers.append("Content-Type", "application/json");

    var requestOptions = {
        method: 'POST',
        headers: headers,
        body: JSON.stringify(articlesArgs),
        redirect: 'follow'
    };

    return fetch(`${TABalancerApiData.apiEndpoint}/api/posts/personalized`, requestOptions)
        .then(response => response.json())
        .then((articles) => {
            console.log('Fetch Articles Response', articles);
            return articles;
        })
        .catch(function(error) {
            return {
                error,
            };
        });
}

function renderArticlesBlock({ elem, articles, rowArgs }){
    if(articles === null)
        return false;

    let RowRenderer = ArticlesCommonRow;
    switch (rowArgs.format) {
        case 'slider': RowRenderer = ArticlesSliderRow; break;
        case 'miscelanea': RowRenderer = ArticlesMiscelaneaRow; break;
    }

    var row = RowRenderer({
        rowArgs: rowArgs,
        articles: articles,
    })
    const $row = $(row);

    $(elem).fadeOut("100", function(){
        $(elem).replaceWith($row);
        $row.find(".article-preview[data-icons]").each( function(){ loadArticlePreviewIcons({ elem: $(this)[0] }) });
        $row.fadeIn("100");
    });
}
