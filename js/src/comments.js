//====================================================
//  FORM SUBMIT
//====================================================
(($) => {

    $(document).on('submit', "#commentform", function(e) {

        e.preventDefault(); // avoid to execute the actual submit of the form.

        var form = $(this);
        var $panel = $(this).closest('.ta-comentarios-block');
        var url = form.attr('action');
        var formData = new FormData(form[0]);

        fetch(`${wpRest.restURL}ta/v1/comment?_wpnonce=${wpRest.nonce}`, {
                method: 'POST',
                body: formData,
            })
            .then( async (response) => {
                return {
                    status: response.status,
                    ok: response.ok,
                    json: await response.json(),
                };
            })
            .then((response) => {
                if (!response.ok) {
                    throw Error(response.json);
                }
                return response.json;
            })
            .then((commentInfo) => {
                console.log(commentInfo.template);
                const $comment = $(commentInfo.template);
                $comment.css('display', 'none');
                $comment.prependTo('#ta-comentarios');
                $comment.slideDown({
                    duration: 800,
                    done: () => {
                        $comment.addClass('new');
                    },
                });
                $('#commentform').slideUp(800);
                $('.ta-comentarios-block .comments-amount').text(commentInfo.total_amount);
            })
            .catch(function(error) {
                $panel.find('.general-error .error-message').html($.parseHTML( error.message )).slideDown();
                $panel.find('.general-error').slideDown();
                console.log('ERROR', error.message);
            });
    });

})(jQuery);

//====================================================
//  LOAD COMMENTS
//====================================================
(($) => {

    let currentPage = 1;
    let loadedArticlesIds = [];
    let loading = false;

    function fetchNextPageContent(){
        if(loading)
            return;
        loading = true;
        const comment__not_in = [];
        $('.ta-comentarios-block').each( () => comment__not_in.push($(this).data('id')) );

        const args = {
            post_id: 815,
            paged: currentPage + 1,
            comment__not_in: comment__not_in,
        };

        return fetch(`${wpRest.restURL}ta/v1/template/comments?_wpnonce=${wpRest.nonce}`, {
                method: 'POST',
                headers: {'Content-Type': 'application/json'},
                body: JSON.stringify(args),
            })
            .then( async (response) => {
                return {
                    status: response.status,
                    ok: response.ok,
                    json: await response.json(),
                };
            })
            .then((response) => {
                if (!response.ok) {
                    throw Error(response.json);
                }
                return response.json;
            })
            .then((data) => {
                currentPage++;
                loading = false;
                return data;
            })
            .catch(function(error) {
                return false;
                loading = false;
            });
    }

    $(document).on('click', '#load-comments-btn', function(){
        fetchNextPageContent().then( (data) => {
            if(data && data.template){
                const $comments = $(data.template);
                $comments.css('display', 'none');
                $comments.appendTo('#ta-comentarios');
                $comments.slideDown(800);
                $('.ta-comentarios-block .comments-amount').text(data.total_amount);
            }
            else{
                $('#load-comments-btn').slideUp();
            }
        });
    });
})(jQuery)
