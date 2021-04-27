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
            })
            .catch(function(error) {
                $panel.find('.general-error .error-message').html($.parseHTML( error.message )).slideDown();
                $panel.find('.general-error').slideDown();
                console.log('ERROR', error.message);
            });
    });
})(jQuery)
