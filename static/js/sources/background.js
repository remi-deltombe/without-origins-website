
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
