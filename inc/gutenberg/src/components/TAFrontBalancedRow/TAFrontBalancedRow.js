const { apiFetch } = wp;
const { Spinner } = wp.components;
const { useState, useEffect, render, Fragment } = wp.element;

const testArticles = [
    {
        id: 2323,
        title: "Artículo de prueba que sale de nueva base de datos",
        url: "google.com",
        cintillo: "Cintillo",
        thumbnail: "https://images6.alphacoders.com/103/thumb-1920-1038319.jpg",
        isopinion: false,
        section: 2323,
        authors: [
            {
                id: 2323,
                name: "Jorge Claudio",
                url: "https://www.cabroworld.com/wp-content/uploads/2017/10/kukk.jpg",
                photo: "https://www.cabroworld.com/wp-content/uploads/2017/10/kukk.jpg",
            },
        ],
        tags: [2323],
        temas: [2323],
        places: [2323],
    },
    {
        id: 73,
        title: "Otro artículo de prueba placeholder",
        url: "google.com",
        cintillo: "",
        thumbnail: "https://steamuserimages-a.akamaihd.net/ugc/940586530515504757/CDDE77CB810474E1C07B945E40AE4713141AFD76/",
        isopinion: true,
        section: 2323,
        authors: [
            {
                id: 2323,
                name: "Juana Gonzales",
                url: "https://images-na.ssl-images-amazon.com/images/I/81YDuTWSHyL.png",
                photo: "https://images-na.ssl-images-amazon.com/images/I/81YDuTWSHyL.png",
            },
        ],
        tags: [2323],
        temas: [2323],
        places: [2323],
    },
    {
        id: 4744,
        title: "Tercer test de prueba de artículo que sale de la nueva base de datos",
        url: "google.com",
        cintillo: "",
        thumbnail: "https://images8.alphacoders.com/108/1081458.jpg",
        isopinion: false,
        section: 2323,
        authors: [],
        tags: [2323],
        temas: [2323],
        places: [2323],
    },
    {
        id: 456456,
        title: "Contundente desmentida de Pfizer a la denuncia de Patricia Bullrich sobre un supuesto pedido de coimas",
        url: "google.com",
        cintillo: "",
        thumbnail: "https://i.pinimg.com/originals/a7/fc/aa/a7fcaa43650adc892c401956a08dc32a.jpg",
        isopinion: false,
        section: 2323,
        authors: [],
        tags: [2323],
        temas: [2323],
        places: [2323],
    },
];

const TAFrontBalancedRow = (props) => {
    const {
        rowArgs,
        onArticlesFetched,
        articlesRequestArgs,
    } = props;

    const [loading, setIsLoading] = useState(true);
    const [isEmpty, setIsEmpty] = useState(false);
    const [rowHTML, setRowHTML] = useState(null);
    const [fetchedArticles, setFetchedArticles] = useState(null);

    // Fetch articles from the new database
    useEffect( () => {
        apiFetch({
            path: `/ta/v1/balancer-db/articles`,
            method: 'POST',
            data: articlesRequestArgs,
        })
            .then((response) => {
                setFetchedArticles(response.articles);
                if(onArticlesFetched){
                    onArticlesFetched({
                        articlesIds: response.articles.map( article => article.postId ),
                    });
                }
                console.log('Fetch Articles Response', response);
            })
            .catch(function(error) {
                setIsEmpty(true);
                setIsLoading(false);
                if(onArticlesFetched){
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
