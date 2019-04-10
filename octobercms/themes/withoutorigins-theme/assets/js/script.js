
class Background
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._el = _('.body-background');
            if(this._el)
            {
                window.addEventListener('resize', this.update.bind(this));
                window.addEventListener('scroll', this.update.bind(this));
                this.update(); 
            }
        });
    }

    update()
    {
        this.setPosition(-this.computePosition())
    }

    computePosition()
    {
        return window.scrollY/4;
    }

    setPosition(position)
    {
        this._el.style.transform = 'translateZ(0) translateY(' + position + 'px)';
    }
}

let background = new Background();


class FrameImage
{
    constructor()
    {
        window.addEventListener('load', e=>{
            this._els = _('.frame-image');
            if(this._els)
            {
                this._els = Array.isArray(this._els) ? this._els : [this._els];
                window.addEventListener('resize', this.update.bind(this));
                window.addEventListener('scroll', this.update.bind(this));
                this.update();
            }
        });
    }

    update()
    {
        this._els.forEach(e=>{
            this.setPosition(e, -this.computePosition(e))
        })
    }

    computePosition(el)
    {
        return -window.scrollY;
    }

    setPosition(el, position)
    {
        //el.style.transform = 'translateZ(0) translateY(' + position + 'px)';
        el.style.marginBottom = '-' + position + 'px';
    }
}

let frameImages = new FrameImage();


function _(s)
{
    return document.querySelector(s);
}
