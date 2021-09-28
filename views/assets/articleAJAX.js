export async function saveArticle(data, callback) {
    let xmlHttp = new XMLHttpRequest();
    xmlHttp.open('post', '/api/article', true);
    xmlHttp.setRequestHeader("Content-Type", "application/json charset=utf-8");
    xmlHttp.onreadystatechange = function() {
        if(xmlHttp.readyState === XMLHttpRequest.DONE && xmlHttp.status === 200)
        {
            callback();
        }
    };
    await xmlHttp.send(JSON.stringify(data));
    return false;
}