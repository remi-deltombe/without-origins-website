
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
