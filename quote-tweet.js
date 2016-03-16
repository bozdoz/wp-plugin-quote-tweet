(function() {
    var start_x,
        start_y,
        tweet_quote_selection = '',
        tweet_popup = createPopUp(),
        checkTO,
        showTO;

    document.addEventListener('mousedown', function (e) {
        if (e.button !== 0 || 
            e.target === tweet_popup ) {
            return;
        }

        hidePopUp();

        start_x = (e.x || e.clientX);
        start_y = (e.y || e.clientY);
    });

    // capture right click
    document.addEventListener('contextmenu', delayedTextSelectionCheck);

    document.addEventListener('mouseup', function (e) {

        if (e.target === tweet_popup) {
            return;
        }

        delayedTextSelectionCheck();

        window.clearTimeout(showTO);
        showTO = window.setTimeout(function () {
            if ( getTextSelection() ) {
                var styleTop = getSelectionTop(),
                    end_x = (e.x || e.clientX),
                    styleLeft = start_x + (end_x - start_x) / 2;
                tweet_popup.style.top = styleTop + 'px';
                tweet_popup.style.left = styleLeft + 'px';
                tweet_popup.style.display = 'block';
            }

            function getSelectionTop () {
                var end_y = (e.y || e.clientY),
                    best_guess_top_padding = (end_y < start_y) ? end_y : start_y,
                    selTop = best_guess_top_padding - 25;
                
                if (window.getSelection) {
                    var sel = window.getSelection();
                    if (sel.rangeCount > 0) {
                        var range = sel.getRangeAt(0);
                        if (!range.collapsed && range.getClientRects) {
                            var startRange = range.cloneRange();
                            startRange.collapse(true);
                            selTop = startRange.getClientRects()[0].top;
                            startRange.detach();
                        }
                    }
                } 

                return selTop + getScrollTop();
            }
        }, 100);
    });

    function getScrollTop () {
        var doc = document.documentElement;
        return (window.pageYOffset || doc.scrollTop)  - (doc.clientTop || 0);
    }

    window.addEventListener('resize', hidePopUp);
    
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
        document.body.appendChild( popup );

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

    function delayedTextSelectionCheck () {
        window.clearTimeout( checkTO );
        checkTO = window.setTimeout(function () {
            tweet_quote_selection = getTextSelection();
            if (!tweet_quote_selection) {
                hidePopUp();
            }
        }, 100);
    }
})();
