(($) => {
    class InfiniteScroll{
        constructor($scroller){
            this.$scroller = $scroller;
            this.initialize();
        }

        getQueryArgs(){
            return this.$scroller.data('query');
        }

        goNext(){
            if(this.loading)
                return;

            const infiniteManager = this;
            let queryArgs = infiniteManager.getQueryArgs();
            const requestBody = {
                query: queryArgs
            };

            infiniteManager.setLoading();
            fetch(`${genInfiniteScroll.homeurl}/wp-json/gen/v1/post/html`, {
                method: 'POST', // or 'PUT'
                body: JSON.stringify(requestBody, function(k, v) { return v === undefined ? null : v; }),
                headers:{
                    'Content-Type': 'application/json'
                }
            })
            .then(function(response) {
                return response.json();
            })
            .then(function(data) {
                if( !data.post ){
                    infiniteManager.end();
                    return
                }
                const $html = $($.parseHTML(data.content));
                const $postContent = $html.find('.post-content');
                $postContent.css('display', 'none');
                $postContent.appendTo( infiniteManager.$scroller.children('.list') );
                $postContent.slideDown();
                queryArgs.post__not_in.push(data.post.ID)
                infiniteManager.$scroller.data('query', queryArgs);
                infiniteManager.removeLoading();

                if( data.found_posts == 1 )
                    infiniteManager.end();
            });
        }

        setLoading(){
            this.loading = true;
            this.getSpinner().slideDown();
            this.getTrigger().slideUp();
        }

        removeLoading(){
            this.loading = false;
            this.getTrigger().slideDown();
            this.getSpinner().slideUp();
        }

        getSpinner(){
            return this.$scroller.children( '.states' ).find( '.spinner' );
        }

        getTrigger(){
            return this.$scroller.children( '.controls' ).children( this.$scroller.data('trigger') );
        }

        end(){
            this.finished = true;
            this.getTrigger().stop().slideUp();
            this.getSpinner().stop().slideUp();
        }


        initialize(){
            const infiniteManager = this;
            const $trigger = infiniteManager.getTrigger();

            $trigger.click(function(){
                infiniteManager.goNext();
            });
        }
    }


    $(document).ready(function(){
        $('.gen-infinite-scroll').each(function(){
            new InfiniteScroll($(this));
        });
    });

})(jQuery)

/*
if( !data.post ){
    infiniteManager.end();
    return
}
var iframe = $("<iframe></iframe>");
iframe.css('display', 'none');
iframe.appendTo( infiniteManager.$scroller.children('.list') );
var iframedoc = iframe[0].contentDocument || iframe[0].contentWindow.document;
$(iframedoc).find();
iframedoc.body.innerHTML = data.content;


// const $html = $($.parseHTML(data.content));
// const $postContent = $html.find('.post-content');

iframe.slideDown();
queryArgs.post__not_in.push(data.post.ID)
infiniteManager.$scroller.data('query', queryArgs);
infiniteManager.removeLoading();

if( data.found_posts == 1 )
    infiniteManager.end();
    */
