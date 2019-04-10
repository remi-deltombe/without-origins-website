
function _(s)
{
    return document.querySelectorAll(s);
}

function uuid()
{
    const g = ()=> 'xxxxxxxx-xxxx-4xxx-yxxx-xxxxxxxxxxxx'.replace(/[xy]/g, c => {
        var r = Math.random() * 16 | 0, v = c == 'x' ? r : (r & 0x3 | 0x8);
        return v.toString(16);
    });

    let uuid;
    do
    {
        uuid=g();
    } while(document.getElementById(uuid));
    return uuid;
}