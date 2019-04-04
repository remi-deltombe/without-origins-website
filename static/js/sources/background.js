
class Background
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._el = _('.body-background');
            window.addEventListener('resize', this.update.bind(this));
            window.addEventListener('scroll', this.update.bind(this));
            this.update();
        });
    }

    update()
    {
        /*
        if(!this._timeout)
        {
            this._timeout = setTimeout(()=>{
                this.setPosition(this.computePosition()/1.5)
                this._timeout = null;
            }, 1);
        }
        */
        this.setPosition(-this.computePosition()/4)
    }

    computePosition()
    {
        return window.scrollY;
    }

    setPosition(position)
    {
        this._el.style.transform = 'translateZ(0) translateY(' + position + 'px)';
    }
}

let background = new Background();
