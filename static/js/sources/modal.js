
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
