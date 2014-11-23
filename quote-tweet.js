(function() {
    var orig_onload = window.onload;

    window.onload = function() {
        var orig_onmouseup = document.onmouseup,
            orig_onmousedown = document.onmousedown,
            orig_resize = window.onresize,
            start_x,
            start_y,
            tweet_quote_selection = '',
            tweet_popup = createPopUp();

        if (orig_onload) {
            orig_onload();
        }

        document.onmousedown = function(e) {
            if (orig_onmousedown) {
                orig_onmousedown(e);
            }

            if ( e.target === tweet_popup ) {
                start_x = null;
                e.preventDefault();
                return;
            }

            start_x = (e.x || e.clientX);
            start_y = (e.y || e.clientY);

            hidePopUp();

            if (window.getSelection) {
                if (window.getSelection().empty) { // Chrome
                    window.getSelection().empty();
                } else if (window.getSelection().removeAllRanges) { // Firefox
                    window.getSelection().removeAllRanges();
                }
            } else if (document.selection) { // IE?
                document.selection.empty();
            }
        };

        document.onmouseup = function(e) {

            if (orig_onmouseup) {
                orig_onmouseup(e);
            }

            if ( start_x === null ) {
                // clicked on tweet button
                // or hasn't triggered mouse down!
                return;
            }

            var end_y = (e.y || e.clientY),
                best_guess_top_padding = (end_y < start_y) ? end_y : start_y,
                styleTop = best_guess_top_padding - 60,
                end_x = (e.x || e.clientX),
                styleLeft = start_x + (end_x - start_x) / 2;

            tweet_quote_selection = getTextSelection();

            if ( tweet_quote_selection ) {
                tweet_popup.style.top = styleTop + 'px';
                tweet_popup.style.left = styleLeft + 'px';
                tweet_popup.style.display = 'block';
            } else {
                hidePopUp();
            }
        };

        window.onresize = function () {
            if ( orig_resize ) {
                orig_resize();
            }
            hidePopUp();
        };
        
        function getTextSelection() {
            var selection;

            if (window.getSelection) {
                selection = window.getSelection();
            } else if (document.selection) {
                selection = document.selection.createRange();
            }

            return selection.toString();
        }



        function createPopUp() {
            var popup = document.createElement('div');
            popup.className = 'quote-tweet-popup';
            document.body.appendChild(popup);

            popup.addEventListener('click', function () {
                var tweet_url = 'https://twitter.com/intent/tweet?text=';
                tweet_url += encodeURIComponent( tweet_quote_selection );
                tweet_url += '&url=' + encodeURIComponent( window.location.href );

                if (QuoteTweet.via) {
                    tweet_url += '&via=' + encodeURIComponent(QuoteTweet.via);
                }
                window.open(tweet_url, '_blank', 'width=640,height=444');
                hidePopUp();
            });

            return popup;
        }

        function hidePopUp() {
            tweet_popup.style.display = 'none';
        }
    };
})();
