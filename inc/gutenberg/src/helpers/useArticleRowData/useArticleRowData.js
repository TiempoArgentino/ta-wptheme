import balancerImage from './balancer-padded.png';

/**
*   @param {object} articles                                                    Articles data. Uses TA_Article_Data format
*   @param {object} cells                                                       Cells configuration
*   @param {int} offset                                                         Defines an offset from which to start selecting articles
*                                                                               from the articles array
*/
export default function useArticleRowData({ articles, cells, offset = 0, isSelected, use_balacer_articles, balancer_allow_fallback }){
    const articlesLeft = articles && articles.length ? articles.length - offset : 0;
    const hasArticles = articlesLeft > 0;

    const getArticle = (index) => {
        const actualIndex = index + offset;
        return hasArticles && articles[actualIndex] ? articles[actualIndex] : null;
    };

    const getCellData = (index) => {
        let article = null;
        // If using the balancer, we return an empty placeholder article that
        // indicates that this cell is supposed to be filled with an article from it
        if(use_balacer_articles && !balancer_allow_fallback){
            article = {
                title: "Artículo del balanceador",
                thumbnail_common: {
                    url: balancerImage,
                },
            };
        }
        else
            article = getArticle(index);

        return {
            article,
            className: article ? '' : 'empty',
        };
    };

    const className = isSelected ? 'selected' : '';

    return {
        getCellData,
        articlesLeft,
        hasArticles,
        className,
    }
}
