
class Tabs
{
    constructor(el)
    {
        this._el = el;
        this._active = 0;
        this._contents = this._el.querySelectorAll('.content');
        this._tabs = this._el.querySelectorAll('.tab');
        this._tabs.forEach((item, i)=>{
            if(hasClass(item , 'is-active'))
            {
                this._active = i;
            }

            item.addEventListener('click', ((i, e)=>{
                e.preventDefault();
                this.activate(i);
            }).bind(null, i));
        })
    }

    activate(index)
    {
        if(index == this._active) return;
        removeClass(this._tabs[this._active], 'is-active');
        removeClass(this._contents[this._active], 'is-active');
        this._active = index;
        addClass(this._tabs[this._active], 'is-active');
        addClass(this._contents[this._active], 'is-active');
    }
}

class TabsManager
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._albums = [..._('.module-tabs')].map(e=>new Tabs(e));
        });
    }
}

let tabsManager = new TabsManager();


class Album
{
    constructor(el)
    {
        this._el = el;
        this._items = this._el.querySelectorAll('.album-item a');
        this._items.forEach((item, i)=>{
            item.addEventListener('click', async e=>{
                e.preventDefault();
                this.open(i);
            });
        })

        window.addEventListener('resize', this.updateSize.bind(this));
        window.addEventListener('scroll', this.updateSize.bind(this));
    }

    open(index)
    {
        if(!this._modal)
        {
            this._dom = document.createElement('div');
            this._dom.className = 'module module-album-modal';
            this._dom.innerHTML = `
                <div class="close"></div>
                <div class="next"></div>
                <div class="prev"></div>
                <div class="image">
                    <img src="" alt="" />
                </div>
            `;
            this._image = this._dom.querySelectorAll('.image img')[0];
            this._close = this._dom.querySelectorAll('.close')[0];
            this._next = this._dom.querySelectorAll('.next')[0];
            this._prev = this._dom.querySelectorAll('.prev')[0];
            this._modal = new Modal(this._dom);

            this._close.addEventListener('click', e=>this._modal.close());
            this._next.addEventListener('click', e=>this.next());
            this._prev.addEventListener('click', e=>this.prev());
        }
        this._width = 0;
        this._height = 0;

        this._index = index;
        this.update();
        this._modal.open();
    }

    next()
    {
        this._index = (this._index + 1) % this._items.length;
        this.update();
    }

    prev()
    {
        this._index = (this._index == 0) ? (this._items.length-1) : (this._index-1);
        this.update();
    }

    update()
    {
        let image = new Image();
        image.onload = e=>{
            this._width = image.width;
            this._height = image.height;
            this.updateSize();
            this._image.src = image.src;
        }
        image.src = this._items[this._index].href;
    }

    updateSize()
    {
        if(this._image)
        {
            let maxHeight = Math.round(document.body.clientHeight * 0.8);
            let maxWidth = Math.round(document.body.clientWidth * 0.8);

            let width = Math.min(this._width, maxWidth);
            let height = width * (this._height/this._width);
            if(height > maxHeight)
            {
                height = maxHeight;
                width = height * (this._width/this._height);
            }

            this._image.style.width = Math.round(width) + 'px';
            this._image.style.height = Math.round(height) + 'px';
        }
    }
}

class AlbumManager
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._albums = [..._('.module-album')].map(e=>new Album(e));
        });
    }
}

let albumManager = new AlbumManager();


class Background
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._el = _('.body-background')[0];
            window.addEventListener('resize', this.update.bind(this));
            window.addEventListener('scroll', this.update.bind(this));
            this.update();
        });
    }

    update()
    {
        this.setPosition(this.computePosition())
    }

    computePosition()
    {
        return -window.scrollY/4;
    }

    setPosition(position)
    {
        this._el.style.transform = 'translateZ(0) translateY(' + position + 'px)';
    }
}

let background = new Background();


class Cookies
{
    static get(name, _default = undefined)
    {
        let cookies = Cookies.retrieve();
        return cookies[name]  ? cookies[name].value : _default;
    }

    static set(name, value, expiration=1)
    {
        let cookies = {};
        cookies[name] = cookies[name]  ? cookies[name] : { name };
        cookies[name].value = value;
        cookies[name].expiration = expiration;
        Cookies.store(cookies);

    }

    static delete(name)
    {
        let cookies = Cookies.retrieve();
        cookies[name] = cookies[name]  ? cookies[name] : { name };
        cookies[name].value = '';
        Cookies.store(cookies);
    }

    static exist(name)
    {
        let cookies = Cookies.retrieve();
        return cookies[name]  ? true : false;
    }

    static retrieve()
    {
        let cookies = {};
        let contents = document.cookie.split(';');
        for(let content of contents)
        {
            let [name, value] = content.split('=').map(v=>v.trim())
            cookies[name] = { name, value, expiration:1 }
        }

        return cookies;
    }

    static store(cookies)
    {
        console.log(cookies);
        for(let i in cookies)
        {
            let cookie = cookies[i];
            let name = cookie.name ? cookie.name : undefined;
            let value = cookie.value ? cookie.value : undefined;
            let expiration = cookie.expiration ? cookie.expiration : 1;

            if(name === undefined) return ;

            let date = new Date();
            date.setTime(date.getTime() + (expiration * 24 * 60 * 60 * 1000));
            
            document.cookie = name + "=" + value + ";expires=" + date.toUTCString() + ";path=/";
        }
    }
}



class Disclaimer
{
    constructor()
    {
        window.addEventListener('load', e=>{
            if(!Cookies.exist('cookies-accepted'))
            {
                this.show();
            }
        });
    }

    el()
    {
        return _('.module-cookies')[0];
    }

    show()
    {
        let el = this.el();
        el.style.display='block';
        el.getElementsByClassName('button')[0].onclick=e=>{
            Cookies.set('cookies-accepted',  true, 15);
            this.hide();
        }
    }


    hide()
    {
        let el = this.el();
        el.style.display='none';
    }
}

let disclaimer = new Disclaimer();


class FrameImage
{
    constructor(el)
    {
        this._el = el;

        window.addEventListener('resize', this.update.bind(this));
        window.addEventListener('scroll', this.update.bind(this));

        this.update();
    }

    update()
    {
        this.setPosition(this.computePosition())
    }

    computePosition()
    {
        return Math.max(-window.scrollY/2, -this._el.offsetHeight);
    }

    setPosition(position)
    {
        this._el.style.marginBottom = Math.round(position) + 'px';
    }
}

class Frame
{
    constructor(el)
    {
        this._el = el;
        this._image = _('.frame-image');
        this._image = this._image.length ? new FrameImage(this._image[0]) : null;
    }
}

class FrameManager
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._albums = [..._('.frame')].map(e=>new Frame(e));
        });
    }
}

let frameManager = new FrameManager();


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

class Menu
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._el = _('.header')[0];
            this._clasname = this._el.className;
            window.addEventListener('resize', this.update.bind(this));
            window.addEventListener('scroll', this.update.bind(this));
            this.update();
        });
    }

    update()
    {
        if(window.scrollY < 20)
        {
            this._el.className = this._clasname;
        }
        else
        {
            this._el.className = this._clasname + ' is-small';
        }
        /*
        if(!this._timeout)
        { 
            //window.scrollY
            this._timeout = setTimeout(()=>{
                this.setPosition(this.computePosition()/1.5)
                this._timeout = null;
            }, 1000/60);
        }
        /*
        this.setPosition(-this.computePosition()/4)
        */
    }
}

let menu = new Menu();


class Modal
{
    constructor(dom, options)
    {
        this._dom = dom;
        this._content = document.createElement('div');
        this._content.className = 'modal-content';
        this._content.appendChild(dom);
        this._modal = document.createElement('div');
        this._modal.className = 'module module-modal';
        this._modal.appendChild(this._content);
        document.body.appendChild(this._modal);
    }

    open()
    {
        this._modal.className = 'module module-modal is-opened';
    }

    close()
    {
        this._modal.className = 'module module-modal';
    }
}
