var sendAjax = (function () {
    var script = document.createElement('script');
    script.type = 'text/javascript';

    return function (url, params, callbackName) {
        params['callback'] = callbackName

        for (param in params) {
            if (url.indexOf("?") != -1)
                url += "&";
            else 
                url += "?";

            url += encodeURIComponent(param) + "=" + encodeURIComponent(params[param]);
        }

        script.src = url;
        document.body.appendChild(script);
        document.body.removeChild(script);
    }
})();