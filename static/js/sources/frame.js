
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
