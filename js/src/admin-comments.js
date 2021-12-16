( ($) => {
    let coreOpenFunction = window.commentReply.open;
    let coreCloseFunction = window.commentReply.close;

    window.commentReply = {
        ...window.commentReply,
        open: function(){
            coreOpenFunction.apply(null, arguments);
        },
        close: function(){
            $('#custom-comment-meta-controls .meta-value').val('');
            coreCloseFunction.apply(null, arguments);
        },
    }

    coreOpenFunction = coreOpenFunction.bind(window.commentReply);
    coreCloseFunction = coreCloseFunction.bind(window.commentReply);
} )(jQuery)
