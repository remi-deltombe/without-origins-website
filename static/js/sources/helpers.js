
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

function addClass(e, c)
{
    let toAdd = c.split(' ');
    let classes = e.className.split(' ');
    e.className = ([...new Set([...classes, ...toAdd])]).join(' ');
}

function removeClass(e, c)
{
    let toRemove = c.split(' ');
    e.className = e.className
        .split(' ')
        .filter(v=>toRemove.indexOf(v) === -1)
        .join(' ');
}

function hasClass(e, c)
{
    return (
        e.className.indexOf(' ' + c + ' ') >= 0 ||
        e.className.indexOf(c + ' ') == 0 ||
        e.className.indexOf(' ' + c) == (e.className.length-c.length-1)
    );
}

function toggleClass(e, c)
{
    let toToggle = c.split(' ');
    toToggle.forEach(c=>{
        if(hasClass(e, c))
        {
            removeClass(e, c);
        }
        else
        {
            addClass(e, c);
        }
    })
    
}

async function preload(paths)
{
    if(!Array.isArray(paths)) return preload([paths]);
    
    const load = path => {
        return new Promise(r=>{
            let img = new Image();
            img.src = path;
            img.onload = ()=>r();
        })
    }

    let promises = [];
    for(path of paths)
    {
        promises.push(load(path));
    }
    return Promise.all(promises);
}