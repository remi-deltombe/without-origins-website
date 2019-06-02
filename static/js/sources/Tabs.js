
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
