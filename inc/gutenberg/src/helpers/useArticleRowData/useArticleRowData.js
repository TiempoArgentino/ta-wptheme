/**
*   @param {object} articles                                                    Articles data. Uses TA_Article_Data format
*   @param {object} cells                                                       Cells configuration
*   @param {int} offset                                                         Defines an offset from which to start selecting articles
*                                                                               from the articles array
*/
export default function useArticleRowData({ articles, cells, offset = 0, isSelected }){
    const articlesLeft = articles && articles.length ? articles.length - offset : 0;
    const hasArticles = articlesLeft > 0;

    const getArticle = (index) => {
        const actualIndex = index + offset;
        return hasArticles && articles[actualIndex] ? articles[actualIndex] : null;
    };

    const getCellData = (index) => {
        const article = getArticle(index);

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
