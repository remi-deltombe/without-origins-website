
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
