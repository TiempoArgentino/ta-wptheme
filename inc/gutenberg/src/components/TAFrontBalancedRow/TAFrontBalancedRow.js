const { apiFetch } = wp;
const { Spinner } = wp.components;
const { useState, useEffect, render, Fragment } = wp.element;

const TAFrontBalancedRow = (props) => {
    const {
        rowArgs,
        cellsCount,
        onArticlesFetched,
        articlesRequestArgs,
    } = props;

    const [loading, setIsLoading] = useState(true);
    const [isEmpty, setIsEmpty] = useState(false);
    const [rowHTML, setRowHTML] = useState(null);
    const [fetchedArticles, setFetchedArticles] = useState(null);

    // Fetch articles from the new database
    useEffect( () => {
        var headers = new Headers();
        headers.append("Content-Type", "application/json");

        var requestOptions = {
            method: 'POST',
            headers: headers,
            body: JSON.stringify(articlesRequestArgs),
            redirect: 'follow'
        };

        fetch(`${TABalancerApiData.apiEndpoint}/api/posts/personalized`, requestOptions)
            .then(response => response.json())
            .then((articles) => {
                console.log('Fetch Articles Response', articles);
                setFetchedArticles(articles);
                if (onArticlesFetched) {
                    onArticlesFetched({
                        articlesIds: articles.slice(0, cellsCount).map(article => article.postId),
                    });
                }
            })
            .catch(function(error) {
                console.log(error);
                setIsEmpty(true);
                setIsLoading(false);
                if (onArticlesFetched) {
                    onArticlesFetched({
                        articlesIds: [],
                    });
                }
            });
    }, []);

    // Fetch article row passing the fetched articles
    useEffect( () => {
        if(fetchedArticles === null)
            return;

        apiFetch({
            path: `/ta/v1/balancer-row`,
            method: 'POST',
            data: {
                articles: [...fetchedArticles],
                row_args: rowArgs,
            },
        })
            .then((response) => {
                console.log(response);
                setRowHTML(response.html);
                setIsLoading(false);
            })
            .catch(function(error) {
                setIsEmpty(true);
                setIsLoading(false);
                // $panel.find('.general-error .error-message').html($.parseHTML( error.message )).slideDown();
                // $panel.find('.general-error').slideDown();
                console.log('ERROR', error.message);
            });
    }, [fetchedArticles]);

    return (
        <>
            {loading &&
            <div class = "d-flex align-items-center">
                <p><Spinner/> Cargando Artículos </p>
            </div>
            }
            {!loading && !isEmpty &&
            <>
                <div dangerouslySetInnerHTML={{__html: rowHTML}} ></div>
            </>
            }
        </>
    );
};


async function getBalancedArticles(data) {
    const response = await fetch(APIURL, {
        method: "POST", // *GET, POST, PUT, DELETE, etc.
        mode: "cors", // no-cors, *cors, same-origin
        cache: "no-cache", // *default, no-cache, reload, force-cache, only-if-cached
        credentials: "same-origin", // include, *same-origin, omit
        headers: new fetch.Headers({
            // Authorization: "Basic " + encode(`${process.env.TAUSER}:${process.env.TAPASSWORD}`),
            "Content-Type": "application/json",
        }),
        redirect: "follow", // manual, *follow, error
        referrerPolicy: "no-referrer", // no-referrer, *no-referrer-when-downgrade, origin, origin-when-cross-origin, same-origin, strict-origin, strict-origin-when-cross-origin, unsafe-url
        body: JSON.stringify(data), // body data type must match "Content-Type" header
    });

    return response; // parses JSON response into native JavaScript objects
}

export default TAFrontBalancedRow;
