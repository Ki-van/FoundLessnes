/**
 * Article __constructor
 */
export let Article =
{
    errors: [],
    send: async function (data, method, callback) {
        let xmlHttp = new XMLHttpRequest();
        xmlHttp.open('post', '/api/article/' + method, true);
        xmlHttp.setRequestHeader("Content-Type", "application/json charset=utf-8");
        xmlHttp.onreadystatechange = function() {
            if(xmlHttp.readyState === XMLHttpRequest.DONE )
            {
                if(xmlHttp.status === 200) {
                    callback();
                    return true;
                }

                if(xmlHttp.status === 422)
                {
                    this.errors = xmlHttp.response;
                    return false;
                }

                return false;
            }
        };
        await xmlHttp.send(JSON.stringify(data));
    }
}