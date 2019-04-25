
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
