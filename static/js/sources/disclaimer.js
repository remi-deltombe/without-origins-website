
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
