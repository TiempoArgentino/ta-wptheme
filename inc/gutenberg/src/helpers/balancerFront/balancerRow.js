import { loadArticlePreviewIcons } from '../../helpers/balancerFront/icons';
const { apiFetch } = wp;
const $ = jQuery;

export async function renderBalancerArticlesRow({ elem, articlesArgs, rowArgs, cellsCount }){
    const balancedArticles = await fetchBalancedArticles({ articlesArgs });

    if(balancedArticles){
        renderArticlesBlock({ elem, articles: balancedArticles, rowArgs });
    }

    return balancedArticles ? balancedArticles.slice(0, cellsCount).map(article => article.postId) : [];
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
            console.log(error);
            return [];
        });
}

async function renderArticlesBlock({ elem, articles, rowArgs}){
    if(articles === null)
        return false;

    const balancerRowHtml = await apiFetch({
        path: `/ta/v1/balancer-row`,
        method: 'POST',
        data: {
            articles: [...articles],
            row_args: rowArgs,
        },
    })
        .then((response) => {
            return response?.html;
        })
        .catch(function(error) {
            console.log('ERROR', error.message);
            return '';
        });

	if(balancerRowHtml){
		$(elem).html(balancerRowHtml);
		const articlesPreviews = elem.querySelectorAll(".article-preview[data-icons]");
        articlesPreviews.forEach(articlePreview => loadArticlePreviewIcons({ elem: articlePreview }));
	}

	return balancerRowHtml;
}
